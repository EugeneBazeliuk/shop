<?php namespace Djetson\Shop\Models;

use PDF;
use BackendAuth;
use Carbon\Carbon;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;

/**
 * Order Model
 *
 * @property int                $id
 * @property int                $status_id
 * @property int                $state_id
 * @property int                $country_id
 * @property int                $manager_id
 * @property int                $customer_id
 * @property int                $payment_method_id
 * @property int                $shipping_method_id
 *
 * @property float              $sub_total
 * @property float              $payment_total
 * @property float              $shipping_total
 * @property float              $total
 *
 * @property string             $comment
 * @property string             $customer_name
 * @property string             $customer_surname
 * @property string             $customer_email
 * @property string             $customer_phone
 *
 * @property bool               $is_draft
 *
 * @property \Carbon\Carbon     $paid_at
 * @property \Carbon\Carbon     $shipped_at
 * @property \Carbon\Carbon     $closed_at
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 * @property \Carbon\Carbon     $deleted_at
 *
 * @property \Djetson\Shop\Models\OrderItem             $items
 * @property \Djetson\Shop\Models\Status                $status
 * @property \RainLab\Location\Models\State             $state
 * @property \RainLab\Location\Models\Country           $country
 * @property \Backend\Models\User                       $manager
 * @property \Rainlab\User\Models\User                  $customer
 * @property \Djetson\Shop\Models\PaymentMethod         $payment_method
 * @property \Djetson\Shop\Models\ShippingMethod        $shipping_method
 *
 * @method \October\Rain\Database\Relations\HasMany     logs
 * @method \October\Rain\Database\Relations\HasMany     items
 * @method \October\Rain\Database\Relations\HasMany     statuses
 *
 * @method \October\Rain\Database\Relations\BelongsTo   status
 * @method \October\Rain\Database\Relations\BelongsTo   state
 * @method \October\Rain\Database\Relations\BelongsTo   country
 * @method \October\Rain\Database\Relations\BelongsTo   manager
 * @method \October\Rain\Database\Relations\BelongsTo   customer
 * @method \October\Rain\Database\Relations\BelongsTo   payment_method
 * @method \October\Rain\Database\Relations\BelongsTo   shipping_method
 *
 * @method static isNew()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_orders';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'track',
        'status',
        'paid_at',
        'shipped_at',
        'payment_method',
        'shipping_method'
    ];

    /** @var array Json fields */
    protected $jsonable  = ['shipping_address', 'billing_address'];

    /** @var array Dates fields */
    protected $dates = [
        'paid_at',
        'shipped_at',
        'closed_at',
    ];

    /** @var array The attributes that should be hidden for arrays. */
    protected $hidden = ['manager'];

    /** @var array Relation HasMany */
    public $hasMany = [
        'logs' => [
            'Djetson\Shop\Models\OrderLog',
            'delete' => true
        ],
        'items' => [
            'Djetson\Shop\Models\OrderItem',
            'delete' => true
        ],
        'statuses' => [
            'Djetson\Shop\Models\OrderStatus',
            'delete' => true
        ]
    ];

    /** @var array Relation BelongTo */
    public $belongsTo = [
        'manager' => [
            'Backend\Models\User'
        ],
        'customer' => [
            'Rainlab\User\Models\User',
        ],
        'country' => [
            'RainLab\Location\Models\Country'
        ],
        'state' => [
            'RainLab\Location\Models\State'
        ],
        'status' => [
            'Djetson\Shop\Models\Status',
        ],
        'payment_method' => [
            'Djetson\Shop\Models\PaymentMethod',
        ],
        'shipping_method' => [
            'Djetson\Shop\Models\ShippingMethod',
        ],
    ];

    public $attachOne = [
        'invoice' => 'System\Models\File',
    ];

    /** @var array Validation rules */
    public $rules = [
        'status'            => ['required'],
        'total'             => ['numeric'],
        'sub_total'         => ['numeric'],
        'payment_total'     => ['required_with:payment_method'],
        'shipping_total'    => ['required_with:shipping_method'],
        // States
        'is_draft'          => ['boolean'],
    ];

    /** @var bool Allow update Warehouse quantity */
    private $allowUpdateWarehouseQuantity;

    //
    // Events
    //

    public function beforeCreate()
    {
        $this->generateInvoice();
//
//        $invoiceFile = new \System\Models\File();
//        $invoiceFile->fromData()


//        $invoce->loadView('djetson.shop::pdf.invoice', []);
//
//        $asd = $invoce->stream();
//
//
//        $tr = PDF::loadView('djetson.shop::pdf.invoice', []);

        $this->manager = BackendAuth::getUser();

        // Sync Warehouse quantity
        if ($this->allowUpdateWarehouseQuantity) {
            $this->updateWarehouseQuantity();
        }
    }

    //
    // Scopes
    //

    /**
     * Scope is new order
     * @param \October\Rain\Database\Builder $query
     * @return mixed
     */
    public function scopeIsNew($query)
    {
        return $query->where('status_id', Settings::get('status_new', true));
    }

    //
    // Setter's
    //

    /**
     * Get Customer Info
     */
    public function getCustomerInfoAttribute()
    {
        if ($this->customer_name) {
            return $this->customer_name;
        } elseif ($this->customer) {
            return implode(' ', [$this->customer->name, $this->customer->surname]);
        }

        return null;
    }

    /**
     * Get Manager Info
     */
    public function getManagerInfoAttribute()
    {
        if ($this->manager) {
            $manager_info = $this->manager->login;
        } else {
            $manager_info = 'No Manager';
        }

        return $manager_info;
    }

    /**
     * Get
     */
    public function getIsPaidAttribute()
    {
        return $this->paid_at ? true : false;
    }

    /**
     * Get
     */
    public function getIsShippedAttribute()
    {
        return $this->shipped_at ? true : false;
    }

    /**
     * Get
     */
    public function getIsClosedAttribute()
    {
        return $this->closed_at ? true : false;
    }

    /**
     * Get text total Attribute
     * @return string
     */
    public function getTextTotalAttribute()
    {
        return Settings::getFormattedPrice($this->total);
    }

    /**
     * Get text subtotal Attribute
     * @return string
     */
    public function getTextSubtotalAttribute()
    {
        return Settings::getFormattedPrice($this->sub_total);
    }

    /**
     * Get text total Attribute
     * @return string
     */
    public function getTextShippingTotalAttribute()
    {
        return Settings::getFormattedPrice($this->shipping_total);
    }

    /**
     * Get text total Attribute
     * @return string
     */
    public function getTextPaymentTotalAttribute()
    {
        return Settings::getFormattedPrice($this->payment_total);
    }

    //
    // Options
    //
    public function getCountryOptions()
    {
        return Country::getNameList();
    }

    public function getStateOptions()
    {
        return State::getNameList($this->country_id);
    }

    //
    // Calculation
    //

    /**
     * @param null $sessionKey
     * return void
     */
    public function updateSubTotal($sessionKey = null)
    {
        $this->sub_total = $this->items()->withDeferred($sessionKey)->sum('total') ?: 0;
    }

    /**
     * @return void
     */
    public function updateTotal()
    {
        $this->total = array_sum([$this->sub_total, $this->payment_total, $this->shipping_total]);;
    }

    /**
     * @return void
     */
    public function updatePaymentTotal()
    {
        $this->payment_total = $this->payment_method ? $this->payment_method->calculateCost($this->sub_total) : null;
    }

    /**
     * @return void
     */
    public function updateShippingTotal()
    {
        $this->shipping_total = $this->shipping_method ? $this->shipping_method->calculateCost($this->sub_total) : null;
    }

    /**
     * Get Order Items
     * @return \October\Rain\Database\Collection
     */
    public function getOrderItems()
    {
        if ($this->sessionKey) {
            $items = $this->items()->withDeferred($this->sessionKey)->get();
        } else {
            $items = $this->items()->get();
        }

        return $items;
    }

    /**
     * Allow Warehouse Sync
     */
    public function allowUpdateWarehouseQuantity()
    {
        $this->allowUpdateWarehouseQuantity = true;
    }

    /**
     * markAsClosed
     */
    public function markAsClosed()
    {
        $this->closed_at = Carbon::now();
    }

    /**
     *
     */
    public function markAsDraft()
    {
        $this->is_draft = true;
    }

    /**
     * Sync Item quantity on Warehouse
     */
    private function updateWarehouseQuantity()
    {
        /** @var \October\Rain\Database\Collection $items */
        $items = $this->items()->withDeferred($this->sessionKey)->get();

        $items->each(function (OrderItem $item) {
            $item->updateWarehouseQuantity();
        });
    }

    /**
     * Activate Order
     * @return void
     * @todo Send Notification
     */
    public function activate()
    {
        $this->is_draft = false;
        $this->save();
    }

    /**
     * Update Order Status
     * @return void
     * @todo Add to log
     */
    public function changeStatus($data)
    {
        $this->fill($data);

        if ($this->status && $this->status->isClosedStatus()) {
            $this->markAsClosed();
        }

        $this->save();
    }

    /**
     * Update Payment Method
     * @param array $data
     * @return void
     */
    public function updatePaymentMethod($data)
    {
        $this->fill($data);
        $this->updatePaymentTotal();
        $this->updateTotal();
        $this->save();
    }

    /**
     * Update Shipping Method
     * @param array $data
     * @return void
     */
    public function updateShippingMethod($data)
    {
        $this->fill($data);
        $this->updateShippingTotal();
        $this->updateTotal();
        $this->save();
    }

    /**
     * Update Order Manager
     * @param $order_id
     * @param $manager_id
     */
    public static function updateManager($order_id, $manager_id)
    {
        $model = self::find($order_id);
        $model->manager = $manager_id;
        $model->save();
    }

    private function generateInvoice()
    {
//        $path = temp_path().str_random(5).'.pdf';
//        $invoice = PDF::loadView('djetson.shop::pdf.invoice', $this->getInvoiceVars());
//        $invoice->save($path);
//
//        $file = new \System\Models\File();
//        $file->fromFile($path);
//
//        $this->invoice = $file;
//
//        unlink($path);
    }

    private function getInvoiceVars()
    {
        $vars = [
            'items' => $this->getOrderItems(),
            'customer_name' => $this->customer_name,
            'customer_surname' => $this->customer_surname,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'sub_total' => $this->getTextSubtotalAttribute(),
            'total' => $this->getTextTotalAttribute(),
        ];

        if ($this->payment_method) {
            array_add($vars, 'payment_method', $this->payment_method->name);
            array_add($vars, 'payment_total', $this->payment_total);
        }

        if ($this->shipping_method) {
            array_add($vars, 'shipping_method', $this->shipping_method->name);
            array_add($vars, 'shipping_total', $this->shipping_total);
        }

        return $vars;
    }
}