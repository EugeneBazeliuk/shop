<?php namespace Djetson\Shop\Models;

use ApplicationException;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Currency Model
 * @package Djetson\Shop
 *
 * @property int                $id
 * @property string             $name
 * @property string             $code
 * @property string             $symbol
 * @property string             $position
 * @property bool               $space
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Traits\Validation
 */
class Currency extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_currencies';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'space',
        'position',
    ];

    /** @var array Validation rules */
    public $rules = [
        'name'      => ['required', 'between:1,255'],
        'code'      => ['required', 'alpha_num', 'size:3', 'unique:djetshop_currencies'],
        'symbol'    => [],
        'space'     => ['boolean'],
        'position'  => ['in:before,after'],
    ];

    /**
     * @throws \ApplicationException
     */
    public function beforeDelete()
    {
        if ($this->isDefault()) {
            throw new ApplicationException(trans('djetson.shop::lang.currencies.errors.delete_default'));
        }
    }

    /**
     * Get preview attribute
     * @return string
     */
    public function getPreviewAttribute()
    {
        return $this->setCurrencyFormat(Settings::formatPrice(100.00));
    }

    /**
     * Get formatted price
     * @param $price
     * @return string
     */
    public function setCurrencyFormat($price)
    {
        $template = [];
        $space = $this->space ? ' ' : '';

        switch ($this->position) {
            case 'before';
                $template = [$this->symbol, $price];
                break;
            case 'after';
                $template = [$price, $this->symbol];
                break;
        }

        return implode($space, $template);
    }

    /**
     * Check Default Currency
     * @return bool
     */
    public function isDefault()
    {
        return $this->id == Settings::get('currency_id') ? true : false;
    }
}