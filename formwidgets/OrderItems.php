<?php namespace Djetson\Shop\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * OrderItems Form Widget
 */
class OrderItems extends FormWidgetBase
{
    use \Backend\Traits\WidgetMaker;
    use \System\Traits\ConfigMaker;

    protected $defaultAlias = 'items';

    /** @var \Backend\Widgets\Form */
    protected $itemFormWidget;

    protected $pm_id;

    protected $sm_id;

    /**
     *
     */
    public function init()
    {
        $this->itemFormWidget = $this->createOrderItemFormWidget();
    }

    /**
     *
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('items');
    }

    /**
     *
     */
    public function onLoadCreateItemForm()
    {
        $this->vars['itemFormWidget'] = $this->itemFormWidget;
        return $this->makePartial('form_create_item');
    }

    /**
     *
     */
    public function onCreateOrderItem()
    {
        $this->model->items()->create($this->itemFormWidget->getSaveData(), $this->sessionKey);
        return $this->refreshOrderItemList();
    }

    /**
     *
     */
    private function prepareVars()
    {
        $this->vars['model'] = $this->model;
    }

    /**
     *
     */
    private function createOrderItemFormWidget()
    {
        $config = $this->makeConfig('$/djetson/shop/models/orderitem/fields.yaml');
        $config->alias = 'orderItemForm';
        $config->arrayName = 'OrderItem';
        $config->model = new \Djetson\Shop\Models\OrderItem;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     *
     */
    private function refreshOrderItemList()
    {
        $f = $this->model->calculateSubTotal($this->sessionKey);


        $this->vars['items'] = $this->model->items()->withDeferred($this->sessionKey)->get();
        return ['#order-items' => $this->makePartial('list')];
    }
}