<?php namespace Djetson\Shop\Models;

use Model;
use BackendAuth;

/**
 * OrderLog Model
 *
 * @property    int     $id
 * @property    int     $author_id
 * @property    int     $order_id
 *
 * @property    string  $event
 * @property    array   $details
 *
 * @property \Djetson\Shop\Models\Order                 $order
 * @property \Backend\Models\User                       $author
 *
 * @method \October\Rain\Database\Relations\BelongsTo   order
 * @method \October\Rain\Database\Relations\BelongsTo   author
 *
 * @mixin \Eloquent
 */
class OrderLog extends Model
{
    const EVENT_CREATE      = 'create';
    const EVENT_UPDATE      = 'update';
    const EVENT_DELETE      = 'delete';
    const EVENT_STATUS_UPDATE   = 'status_update';

    /** @var string The database table used by the model. */
    public $table = 'djetshop_order_logs';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [];

    /** @var array Json fields */
    protected $jsonable  = ['details'];

    /** @var array The accessors to append to the model's array form. */
    protected $appends = [
        'message',
    ];

    /** @var array Relation BelongTo */
    public $belongsTo = [
        'order' => [
            'Djetson\Shop\Models\Order',
        ],
        'author' => [
            'Backend\Models\User'
        ]
    ];

    public function getMessageAttribute()
    {
        return trans(sprintf('djetson.shop::lang.order_logs.messages.%s', $this->event));
    }

    public function getInformationAttribute()
    {
        return array_except($this->details, ['items']);
    }

    public function getItemsAttribute()
    {
        return isset($this->details['items']) ? $this->details['items'] : [];
    }

    public static function orderCreated(Order $order)
    {
        $details = array_merge(
            self::prepareOrderItems($order),
            self::prepareOrderCustomer($order),
            self::prepareOrderPayment($order),
            self::prepareOrderShipping($order),
            self::prepareOrderTotals($order)
        );

        self::makeLog($order->id, self::EVENT_CREATE, $details);
    }

    public static function orderUpdated($id)
    {
        self::makeLog($id, self::EVENT_UPDATE);
    }

    public static function orderDeleted($id)
    {
        self::makeLog($id, self::EVENT_DELETE);
    }

    public static function orderStatusUpdate($id)
    {
        self::makeLog($id, self::EVENT_STATUS_UPDATE);
    }

    private static function makeLog($order_id, $event, $details = null)
    {
        $user = BackendAuth::getUser();

        $model = new static();
        $model->author = $user;
        $model->order = $order_id;
        $model->event = $event;
        $model->details = $details;
        $model->save();
    }

    private static function prepareOrderItems(Order $order)
    {
        $items = $order->items()->get();

        return [
            'items' => $items->toArray()
        ];
    }

    private static function prepareOrderCustomer(Order $order)
    {
        return [
            'customer_name' => $order->customer_name,
            'customer_surname' => $order->customer_surname,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'comment' => $order->comment,
        ];
    }

    private static function prepareOrderPayment(Order $order)
    {
        return $order->payment_method ? ['payment_method' => $order->payment_method->name] : [];
    }

    private static function prepareOrderShipping(Order $order)
    {
        return $order->shipping_method ? ['shipping_method' => $order->shipping_method->name] : [];
    }

    private static function prepareOrderTotals(Order $order)
    {
        return [
            'payment_total' => $order->text_payment_total,
            'shipping_total' => $order->text_shipping_total,
            'sub_total' => $order->text_sub_total,
            'total' => $order->text_total
        ];
    }
}