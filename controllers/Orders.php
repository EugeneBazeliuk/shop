<?php namespace Djetson\Shop\Controllers;

use Flash;
use Validator;
use BackendMenu;
use ValidationException;
use Backend\Classes\Controller;
use Djetson\Shop\Models\Order;
use Djetson\Shop\Models\OrderLog;
use Djetson\Shop\Models\PaymentMethod;
use Djetson\Shop\Models\ShippingMethod;
use Djetson\Shop\Models\Settings;

/**
 * Orders Back-end Controller
 *
 * @property \Backend\Widgets\Form $statusFormWidget
 * @property \Backend\Widgets\Form $paymentMethodFormWidget
 * @property \Backend\Widgets\Form $shippingMethodFormWidget
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\RelationController
 */
class Orders extends Controller
{
    public $bodyClass = 'compact-container';

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['djetson.shop.access_orders'];

    protected $statusFormWidget;
    protected $paymentMethodFormWidget;
    protected $shippingMethodFormWidget;

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Djetson.Shop', 'shop', 'orders');
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
        $this->statusFormWidget = $this->createChangeStatusFormWidget();
        $this->paymentMethodFormWidget = $this->createPaymentMethodFormWidget();
        $this->shippingMethodFormWidget = $this->createShippingMethodFormWidget();
    }

    //
    // EVENTS
    //

    /**
     * Event before form create
     * @param \Djetson\Shop\Models\Order $model
     */
    public function formBeforeCreate($model)
    {
        $model->markAsDraft();
        $model->allowUpdateWarehouseQuantity();
        $model->status = Settings::get('status_new_id');
        $model->updateSubTotal($this->formGetSessionKey());
        $model->payment_total = $this->getPaymentTotal(post('Order.payment_method'), $model->sub_total);
        $model->shipping_total = $this->getShippingTotal(post('Order.shipping_method'), $model->sub_total);
        $model->updateTotal();
    }

    /**
     * Event after form create
     * @param \Djetson\Shop\Models\Order $model
     */
    public function formAfterCreate($model)
    {
        OrderLog::orderCreated($model);
    }

    //
    // ORDER MANAGER
    //

    /**
     * Display BackendUser popup
     * @return mixed
     */
    public function preview_onLoadAddManagerForm()
    {
        $this->vars['users'] = \Backend\Models\User::all();
        return $this->makePartial('form_add_manager');
    }

    /**
     * Add manager to order
     * @param $record_id
     * @return void
     */
    public function preview_onAddManager($record_id)
    {
        Order::updateManager($record_id, post('manager'));
        Flash::success('Ok');
    }

    //
    // CHANGE STATUS
    //

    /**
     * @return \Backend\Classes\WidgetBase
     */
    private function createChangeStatusFormWidget()
    {
        $config = $this->makeConfig('$/djetson/shop/models/order/fields_change_status.yaml');
        $config->alias = 'statusForm';
        $config->arrayName = 'Status';
        $config->model = new \Djetson\Shop\Models\Order;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * @return mixed
     */
    public function preview_onLoadChangeStatusForm()
    {
        $this->vars['statusFormWidget'] = $this->statusFormWidget;
        return $this->makePartial('form_change_status');
    }

    /**
     * @param $record_id
     * @return \Redirect
     * @throws \ValidationException
     */
    public function preview_onChangeStatus($record_id)
    {
        $data = $this->statusFormWidget->getSaveData();

        $rules = [
            'status' => ['required']
        ];

        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        /** @var Order $model */
        $model = $this->formFindModelObject($record_id);
        $model->changeStatus($data);

        Flash::success(trans('djetson.shop::lang.orders.status_changed_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    //
    // CHANGE PAYMENT METHOD
    //

    private function createPaymentMethodFormWidget()
    {
        $config = $this->makeConfig('$/djetson/shop/models/order/fields_payment_method.yaml');
        $config->alias = 'paymentMethodForm';
        $config->arrayName = 'PaymentMethod';
        $config->model = $this->formCreateModelObject();
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    public function preview_onLoadPaymentMethodForm()
    {
        $this->vars['paymentMethodFormWidget'] = $this->paymentMethodFormWidget;
        return $this->makePartial('form_change_payment_method');
    }

    public function preview_onChangePaymentMethod($record_id)
    {
        $data = $this->paymentMethodFormWidget->getSaveData();
        /** @var Order $model */
        $model = $this->formFindModelObject($record_id);
        $model->updatePaymentMethod($data);

        Flash::success(trans('djetson.shop::lang.orders.status_changed_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    //
    // CHANGE SHIPPING METHOD
    //

    /**
     * Create ShippingMethod FormWidget
     * @return \Backend\Classes\WidgetBase
     */
    private function createShippingMethodFormWidget()
    {
        $config = $this->makeConfig('$/djetson/shop/models/order/fields_shipping_method.yaml');
        $config->alias = 'shippingMethodForm';
        $config->arrayName = 'ShippingMethod';
        $config->model = $this->formCreateModelObject();
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * Handler load ShippingMethod form
     * @return mixed
     */
    public function preview_onLoadShippingMethodForm()
    {
        $this->vars['shippingMethodFormWidget'] = $this->shippingMethodFormWidget;
        return $this->makePartial('form_change_shipping_method');
    }

    /**
     * Handler change ShippingMethod
     * @param $record_id
     * @return \Redirect
     */
    public function preview_onChangeShippingMethod($record_id)
    {
        $data = $this->shippingMethodFormWidget->getSaveData();
        /** @var Order $model */
        $model = $this->formFindModelObject($record_id);
        $model->updateShippingMethod($data);

        Flash::success(trans('djetson.shop::lang.orders.shipping_method_updated_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    //
    // TOTALS
    //

    public function totalsRender($model)
    {
        $this->vars['model'] = $model;
        return $this->makePartial('preview_totals');
    }

    //
    //
    //

    /**
     * Activate order handler
     * @param int $record_id
     * @return \Redirect
     */
    public function preview_onActivateOrder($record_id)
    {
        /** @var Order $model */
        $model = $this->formFindModelObject($record_id);
        $model->activate();

        Flash::success(trans('djetson.shop::lang.orders.activated_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    public function columnStatusRender($status)
    {
        return sprintf('<span class="btn btn-label" style="background: %s">%s</span>', $status->color, $status->name);
    }

    /**
     * Get payment method total
     * @param int       $method_id
     * @param double    $sub_total
     * @return double|null
     */
    private function getPaymentTotal($method_id, $sub_total)
    {
        return PaymentMethod::getPaymentCost($method_id, $sub_total);
    }

    /**
     * Get shipping method total
     * @param int       $method_id
     * @param double    $sub_total
     * @return double|null
     */
    private function getShippingTotal($method_id, $sub_total)
    {
        return ShippingMethod::getShippingCost($method_id, $sub_total);
    }

    //
    //
    //

    public function formExtendRefreshData($host, $data)
    {
        return array_merge($data, $this->extendFormRefreshCustomerData($data));
    }

    private function extendFormRefreshCustomerData($data)
    {
        if (empty($data['customer'])) {
            return;
        }

        if (!$this->formGetContext() == 'create') {
            return;
        }

        if ($customer = \RainLab\User\Models\User::find($data['customer'])->first()) {
            $data['customer_name'] = $customer->name;
            $data['customer_surname'] = $customer->surname;
            $data['customer_email'] = $customer->email;
            $data['customer_phone'] = $customer->phone;
            $data['address'] = $customer->address;
            $data['zip'] = $customer->zip;
            $data['country'] = $customer->country->id;
            $data['state'] = $customer->state->id;
        }

        return $data;
    }
}