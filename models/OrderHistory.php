<?php namespace Djetson\Shop\Models;

use Log;
use Model;

/**
 * OrderHistory Model
 */
class OrderHistory extends Model
{
    const CODE_CREATED = 'created';
    const CODE_STATUS_UPDATED = 'status_updated';
    const CODE_PAYMENT_METHOD_UPDATED = 'payment_method_updated';
    const CODE_SHIPPING_METHOD_UPDATED = 'shipping_method_updated';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'djetson_shop_order_histories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'order_id',
        'type',
        'data'
    ];

    /** @var array The accessors to append to the model's array form. */
    protected $appends = [
        'message',
    ];

    public function getMessageAttribute()
    {
        return trans(sprintf('djetson.shop::lang.order_histories.messages.%s', $this->type));
    }

    public static function OrderCreated($order_id)
    {
        self::create([
            'order_id' => $order_id,
            'type' => self::CODE_CREATED
        ]);
    }

    public static function paymentMethodUpdated($order_id)
    {
        self::create([
            'order_id' => $order_id,
            'type' => self::CODE_PAYMENT_METHOD_UPDATED
        ]);
    }

    public static function shippingMethodUpdated($order_id)
    {
        self::create([
            'order_id' => $order_id,
            'type' => self::CODE_SHIPPING_METHOD_UPDATED
        ]);
    }

    public static function statusUpdated($order_id)
    {
        self::create([
            'order_id' => $order_id,
            'type' => self::CODE_STATUS_UPDATED
        ]);
    }
}
