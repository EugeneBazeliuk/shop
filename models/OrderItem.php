<?php namespace Djetson\Shop\Models;

use Model;
use ApplicationException;
use October\Rain\Database\Traits\Validation;

/**
 * OrderItem Model
 *
 * @property    int     $id
 * @property    int     $order_id
 * @property    int     $product_id
 * @property    int     $warehouse_id
 * @property    int     $quantity
 * @property    string  $name
 * @property    string  $sku
 * @property    double  $price
 * @property    double  $total
 *
 * @property    \Djetson\Shop\Models\Order      $order
 * @property    \Djetson\Shop\Models\Product    $product
 * @property    \Djetson\Shop\Models\Warehouse  $warehouse
 *
 * @method      \October\Rain\Database\Relations\BelongsTo|\Djetson\Shop\Models\Order order
 * @method      \October\Rain\Database\Relations\BelongsTo|\Djetson\Shop\Models\Product product
 * @method      \October\Rain\Database\Relations\BelongsTo|\Djetson\Shop\Models\Warehouse warehouse
 *
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_order_items';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'product',
        'warehouse',
        'price',
        'quantity',
    ];

    /** @var array Relations */
    public $belongsTo = [
        'order' => 'Djetson\Shop\Models\Order',
        'product' => 'Djetson\Shop\Models\Product',
        'warehouse' => 'Djetson\Shop\Models\Warehouse',
    ];

    /** @var array Validation rules */
    public $rules = [
        'order'         => [''],
        'product'       => ['required'],
        'warehouse'     => ['required'],
        'price'         => ['required', 'numeric'],
        'quantity'      => ['required', 'integer'],
    ];

    //
    // Filter
    //
    public function filterFields($fields, $context = null)
    {
        if (!$this->exists && $this->product) {
            $fields->price->value = $this->product->price;
        }
    }

    //
    // Events
    //

    public function beforeCreate()
    {
        $this->name = $this->product->getAttribute('name');
        $this->sku  = $this->product->getAttribute('sku');
    }

    public function beforeSave()
    {
        $this->total = $this->price * $this->quantity;
    }

    //
    // Mutators
    //

    public function getTextTotalAttribute()
    {
        return Settings::getFormattedPrice($this->total);
    }

    public function getTextPriceAttribute()
    {
        return Settings::getFormattedPrice($this->price);
    }

    //
    // Options
    //

    /**
     * Get options for Warehouse field
     * @return array
     */
    public function getWarehouseOptions()
    {
        return $this->product ? $this->product->getWarehousesList() : [];
    }

    /**
     * Get Item from Warehouse
     * @throws ApplicationException
     * @return void
     */
    public function updateWarehouseQuantity()
    {
        if (!$this->warehouse->updateProductQuantity($this->product_id, $this->quantity)) {
            throw new ApplicationException(trans('djetson.shop::lang.order_items.errors.warehouse_update', [
                'product' => $this->product->name,
                'warehouse' => $this->warehouse->name,
                'quantity' => $this->quantity
            ]));
        }
    }
}