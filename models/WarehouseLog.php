<?php namespace Djetson\Shop\Models;

use Model;
use BackendAuth;

/**
 * WarehouseLog Model
 *
 * @property    int     $id
 * @property    int     $quantity
 * @property    string  $event
 *
 * @property \Backend\Models\User $author
 * @property \Djetson\Shop\Models\Product $product
 * @property \Djetson\Shop\Models\Warehouse $warehouse
 *
 * @method \October\Rain\Database\Relations\BelongsTo author
 * @method \October\Rain\Database\Relations\BelongsTo product
 * @method \October\Rain\Database\Relations\BelongsTo warehouse
 */
class WarehouseLog extends Model
{
    const EVENT_TAKE     = 'take';
    const EVENT_PUT      = 'put';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'djetshop_warehouse_logs';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /** @var array Relation BelongTo */
    public $belongsTo = [
        'author' => [
            'Backend\Models\User'
        ],
        'product' => [
            'Djetson\Shop\Models\Product',
        ],
        'warehouse' => [
            'Djetson\Shop\Models\Warehouse',
        ]
    ];

    //
    // Setters
    //

    public function getTextEventAttribute()
    {
        return trans(sprintf('djetson.shop::lang.warehouse_logs.events.%s', $this->event));
    }

    //
    //
    //

    /**
     * @param $warehouse_id
     * @param $product_id
     * @param $quantity
     */
    public static function take($warehouse_id, $product_id, $quantity)
    {
        self::makeLog($warehouse_id, $product_id, $quantity, self::EVENT_TAKE);
    }

    public static function put($warehouse_id, $product_id, $quantity)
    {
        self::makeLog($warehouse_id, $product_id, $quantity, self::EVENT_PUT);
    }

    private static function makeLog($warehouse_id, $product_id, $quantity, $event)
    {
        $model = new static();
        $model->author = BackendAuth::getUser();
        $model->event = $event;
        $model->quantity = $quantity;
        $model->product = $product_id;
        $model->warehouse = $warehouse_id;
        $model->save();
    }
}
