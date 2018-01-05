<?php namespace Djetson\Shop\Models;

use DB;
use Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * Warehouse Model
 *
 * @property int        $id
 * @property string     $name
 * @property string     $code
 * @property string     $description
 * @property bool       $is_active
 *
 * @property \October\Rain\Database\Collection   $products
 *
 * @method \October\Rain\Database\Relations\HasMany logs
 * @method \October\Rain\Database\Relations\BelongsToMany products
 *
 * @method static filterByProduct($product_id)
 */
class Warehouse extends Model
{
    use Sluggable;
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_warehouses';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        // Base
        'name',
        'code',
        'description',
        // States
        'is_active'
    ];

    /** @var array Validation rules */
    public $rules = [
        // Base
        'name'          => ['required', 'between:1,255'],
        'code'          => ['required:update', 'between:1,255', 'unique:djetshop_warehouses'],
        'description'   => [],
        // States
        'is_active'     => ['boolean'],
    ];

    /** @var array Generate slugs for these attributes. */
    protected $slugs = ['code' => 'name'];

    /** @var array Relation HasMany */
    public $hasMany = [
        'logs' => [
            'Djetson\Shop\Models\WarehouseLog',
            'delete' => true
        ],
    ];

    /** @var array Relation BelongsToMany */
    public $belongsToMany = [
        'products' => [
            'Djetson\Shop\Models\Product',
            'table'         => 'djetshop_products_warehouses',
            'key'           => 'warehouse_id',
            'otherKey'      => 'product_id',
            'pivot'         => ['quantity'],
            'pivotModel'    => 'Djetson\Shop\Models\ProductWarehouse'
        ],
    ];

    //
    // Scopes
    //

    /**
     * Filter by product
     * @param \October\Rain\Database\Builder $query
     * @param int                            $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeFilterByProduct($query, $filter)
    {
        return $query->whereHas('products', function(\October\Rain\Database\QueryBuilder $product) use ($filter) {
            $product->where('id', $filter);
        });
    }

    /**
     * Get count products attribute
     * @return mixed
     */
    public function getCountProductsAttribute()
    {
        return $this->products()->withPivot('quantity')->sum('quantity');
    }

    /**
     * Update product quantity on Warehouse
     *
     * @param int $product_id
     * @param int $quantity
     *
     * @return bool
     */
    public function updateProductQuantity($product_id, $quantity)
    {
        if ($quantity > 0) {
            return $this->takeProduct($product_id, $quantity);
        } else {
            return $this->putProduct($product_id, $quantity);
        }
    }

    /**
     * Take Product form Warehouse
     * @param $product_id
     * @param $quantity
     *
     * @return bool
     */
    private function takeProduct($product_id, $quantity)
    {
        $result = $this->products()
            ->newPivotStatementForId($product_id)
            ->where('quantity', '>=', $quantity)
            ->decrement('quantity', $quantity);

        if ($result) {
            WarehouseLog::take($this->id, $product_id, $quantity);
        }

        return $result;
    }

    /**
     * Put Product on Warehouse
     * @param $product_id
     * @param $quantity
     *
     * @return bool
     */
    private function putProduct($product_id, $quantity)
    {
        $result = $this->products()
            ->newPivotStatementForId($product_id)
            ->increment('quantity', $quantity);

        if ($result) {
            WarehouseLog::put($this->id, $product_id, $quantity);
        }

        return $result;
    }
}