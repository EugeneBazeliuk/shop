<?php namespace Djetson\Shop\Models;

use October\Rain\Database\Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * BindingType Model
 *
 * @property int        $id
 * @property string     $name
 * @property string     $code
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 * @mixin \October\Rain\Database\Traits\Validation
 */
class BindingType extends Model
{
    use Sluggable;
    use Validation;

    /** @var string The database table used by the model. */
    public $table = 'djetshop_binding_types';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'name',
        'code'
    ];

    /** @var array Generate slugs for these attributes. */
    protected $slugs = ['code' => 'name'];

    /** @var string The database timestamps. */
    public $timestamps = false;

    /** @var array Validation rules */
    public $rules = [
        // Base
        'name' => ['required', 'between:1,255'],
        'code' => ['required:update', 'alpha_dash', 'between:1,255', 'unique:djetshop_binding_types'],
    ];
}