<?php namespace Djetson\Shop\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * PropertyValue Model
 *
 * @property int $id
 * @property string $value
 * @property int $property_id
 *
 * @property \Djetson\Shop\Models\Property $property
 * @method  \October\Rain\Database\Relations\BelongsTo property
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 * @mixin \October\Rain\Database\Traits\Validation
 */
class PropertyValue extends Model
{
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_property_values';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'property_id',
        'value'
    ];

    /** @var string The database timestamps. */
    public $timestamps = false;

    /** @var array Relations */
    public $belongsTo = [
        'property' => [
            'Djetson\Shop\Models\Property',
        ],
    ];

    /** @var array Validation rules */
    public $rules = [
        'property'  => ['required'],
        'value'     => ['required', 'between:1,255'],
    ];

    /**
     * Action BeforeValidate
     */
    public function beforeValidate()
    {
        $rule = 'unique:djetshop_property_values,value,NULL,id,property_id, %d';
        array_push($this->rules['value'], sprintf($rule, $this->property_id));
    }

    /**
     * @param $query \October\Rain\Database\Builder
     * @param $type \October\Rain\Database\Model
     *
     * @return mixed
     */
    public function scopePropertyValues($query, $type)
    {
        if ($type->exists) {
            $query->where('property_id', $type->property_id);
        } elseif (post('foreign_id')) {
            $query->where('property_id', post('foreign_id'));
        }

        return $query;
    }
}