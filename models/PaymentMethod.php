<?php namespace Djetson\Shop\Models;

use Config;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * PaymentMethod Model
 * @package Djetson\Shop
 *
 * @property int                $id
 * @property string             $name
 * @property string             $provider
 * @property double             $cost
 * @property boolean            $is_active
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Traits\Validation
 *
 * @todo Реализовать правила RULES | FIXED or %
 * @todo Вывести в настройки allow
 */
class PaymentMethod extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_payment_methods';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'name',
        'provider',
        'cost',
        'is_active',
    ];

    /** @var string The database timestamps. */
    public $timestamps = false;

    /** @var array Validation rules */
    public $rules = [
        'name'      => ['required', 'between:1,255'],
        'provider'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'between:1,255'],
        'cost'      => ['required', 'numeric'],
        'is_active' => ['boolean'],
    ];

    /**
     * Provider list
     * @return array
     */
    public function getProviderOptions()
    {
        return array_pluck(Config::get('djetson.shop::payment.methods', []), 'name', 'code');
    }

    /**
     * Calculate Cost
     * @param $sub_total
     *
     * @return int
     */
    public function calculateCost($sub_total)
    {
        return $this->cost;
    }

    /**
     * Get Payment Cost
     * @param $id
     * @param $subtotal
     *
     * @return int|null
     */
    public static function getPaymentCost($id, $subtotal)
    {
        /** @var self $model */
        $model = self::find($id);
        return $model ? $model->calculateCost($subtotal) : null;
    }
}