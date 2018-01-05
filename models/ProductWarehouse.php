<?php namespace Djetson\Shop\Models;

use October\Rain\Database\Pivot;
use October\Rain\Database\Traits\Validation;

/**
 * ProductWarehouse Model
 *
 * @mixin \October\Rain\Database\Traits\Validation
 */
class ProductWarehouse extends Pivot
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_products_warehouses';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'quantity'
    ];

    /** @var array Validation rules */
    public $rules = [
        'quantity'     => 'required|integer|min:0',
    ];
}