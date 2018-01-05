<?php namespace Djetson\Shop\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use October\Rain\Database\Traits\Sortable;

/**
 * PropertyGroup Model
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 * @mixin \October\Rain\Database\Traits\Sluggable
 * @mixin \October\Rain\Database\Traits\Validation
 */
class PropertyGroup extends Model
{
    use Validation;
    use Sortable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'djetshop_property_groups';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /** @var string The database timestamps. */
    public $timestamps = false;

    /** @var array Relations */
    public $hasMany = [
        'properties_count' => ['Djetson\Shop\Models\Property', 'key' => 'group_id', 'count' => true]
    ];

    /** @var array Validation rules */
    public $rules = [
        'name' => ['required', 'between:1,255', 'unique:djetshop_property_groups'],
    ];
}