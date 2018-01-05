<?php namespace Djetson\Shop\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Sortable;

/**
 * Property Model
 *
 * @property \Djetson\Shop\Models\PropertyGroup $group
 * @method  \October\Rain\Database\Relations\BelongsTo group
 *
 * @property \Djetson\Shop\Models\PropertyValue $values
 * @method  \October\Rain\Database\Relations\HasMany values
 *
 * @property \Djetson\Shop\Models\PropertyValue $values_count
 * @method  \October\Rain\Database\Relations\HasMany values_count
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 * @mixin \October\Rain\Database\Traits\Sluggable
 * @mixin \October\Rain\Database\Traits\Validation
 */
class Property extends Model
{
    use Sluggable;
    use Validation;
    use Sortable;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_properties';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active'
    ];

    /** @var array Generate slugs for these attributes. */
    protected $slugs = ['code' => 'name'];

    /** @var string The database timestamps. */
    public $timestamps = false;

    /** @var array Relations */
    public $belongsTo = [
        'group' => [
            'Djetson\Shop\Models\PropertyGroup',
        ],
    ];
    public $hasMany = [
        'values'        => 'Djetson\Shop\Models\PropertyValue',
        'values_count'  => ['Djetson\Shop\Models\PropertyValue', 'count' => true]
    ];

    /** @var array Validation rules */
    public $rules = [
        'name'          => ['between:1,255'],
        'code'          => ['required:update', 'alpha_dash', 'between:1,255', 'unique:djetshop_properties'],
        'description'   => [],
        'is_active'     => ['boolean'],
    ];
}
