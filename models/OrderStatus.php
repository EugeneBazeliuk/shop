<?php namespace Djetson\Shop\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * OrderStatus Model
 *
 * @mixin \Eloquent
 */
class OrderStatus extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_order_statuses';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'status',
        'comment',
    ];

    /** @var array Relation BelongTo */
    public $belongsTo = [
        'status' => [
            'Djetson\Shop\Models\Status',
        ],
        'order' => [
            'Djetson\Shop\Models\Order',
        ],
    ];

    /** @var array Validation rules */
    public $rules = [
        'order_id'  => ['required'],
        'status_id' => ['required'],
        'comment'   => [],
    ];
}