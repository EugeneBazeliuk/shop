<?php namespace Djetson\Shop\Models;

use October\Rain\Database\Pivot;
use October\Rain\Database\Traits\Validation;

/**
 * ProductProperty Model
 *
 * @property \Djetson\Shop\Models\Product $product
 * @method \October\Rain\Database\Relations\BelongsTo product
 *
 * @property \Djetson\Shop\Models\Property $property
 * @method \October\Rain\Database\Relations\BelongsTo property
 *
 * @property \Djetson\Shop\Models\PropertyValue $property_value
 * @method \October\Rain\Database\Relations\BelongsTo property_value
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 * @todo рефакторинг в pivot
 */
class ProductProperty extends Pivot
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_products_properties';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [];

    /** @var array Relations */
    public $belongsTo = [
        'product' => [
            'Djetson\Shop\Models\Product',
        ],
        'property' => [
            'Djetson\Shop\Models\Property',
        ],
        'property_value' => [
            'Djetson\Shop\Models\PropertyValue',
            'scope' => 'PropertyValues'
        ],
    ];

    /** @var array Validation rules */
    public $rules = [
        'product'       => ['required'],
        'property'      => ['required'],
        'property_value'    => ['required']
    ];
}