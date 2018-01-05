<?php namespace Djetson\Shop\Models;

/**
 * Product Export
 *
 * @property-read \Djetson\Shop\Models\Binding|\Illuminate\Database\Eloquent\Collection $product_bindings
 * @property-read \Djetson\Shop\Models\Category $product_category
 * @property-read \Djetson\Shop\Models\Category|\Illuminate\Database\Eloquent\Collection $product_categories
 * @property-read \Djetson\Shop\Models\Manufacturer $product_manufacturer
 * @property-read \Djetson\Shop\Models\Property|\Illuminate\Database\Eloquent\Collection $product_properties
 *
 * @mixin \Eloquent
 * @package Djetson\Shop
 */
class ProductExport extends \Backend\Models\ExportModel
{
    public $bindingTypes;
    public $propertyValues;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'djetshop_products';

    /**
     * The accessors to append to the model's array form.
     * @var array
     */
    protected $appends = [
        'bindings',
        'category',
        'categories',
        'manufacturer',
        'properties'
    ];

    public $belongsTo = [
        'product_category' => [
            'Djetson\Shop\Models\Category',
            'key' => 'category_id'
        ],
        'product_manufacturer' => [
            'Djetson\Shop\Models\Manufacturer',
            'key' => 'manufacturer_id'
        ],
    ];

    public $belongsToMany = [
        'product_bindings' => [
            'Djetson\Shop\Models\Binding',
            'table'         => 'djetshop_products_bindings',
            'key'           => 'product_id',
            'otherKey'      => 'binding_id',
        ],
        'product_categories' => [
            'Djetson\Shop\Models\Category',
            'table'         => 'djetshop_products_categories',
            'key'           => 'product_id',
            'otherKey'      => 'category_id',
        ],
        'product_properties' => [
            'Djetson\Shop\Models\Property',
            'table'         => 'djetshop_products_properties',
            'key'           => 'product_id',
            'otherKey'      => 'property_id',
            'pivot'         => ['property_value_id'],
        ],
    ];

    /**
     * Export Data
     * @param      $columns
     * @param null $sessionKey
     *
     * @return array
     */
    public function exportData($columns, $sessionKey = null)
    {
        $products = new self();

        $f = $products->with([
            'product_bindings',
            'product_category',
            'product_categories',
            'product_manufacturer',
            'product_properties'
        ])->get()->each(function($product) use ($columns) {
            /** @var $product \Djetson\Shop\Models\Product */
            $product->addVisible($columns);
        })->toArray();

        return $f;
    }

    /**
     * Get bindings attribute
     */
    public function getBindingsAttribute()
    {
        if ($this->product_bindings->count()) {

            $bindings = [];

            $this->product_bindings->each(function ($binding) use (&$bindings) {
                $bindings[] = $this->encodeArrayValue([$this->getBindingTypeCodeById($binding->binding_type_id), $binding->name], '::');
            });

            return $this->encodeArrayValue($bindings);
        }

        return '';
    }

    /**
     * Get category attribute
     * @return string
     */
    public function getCategoryAttribute()
    {
        return $this->product_category ? $this->product_category->name : '';
    }

    /**
     * Get categories attribute
     */
    public function getCategoriesAttribute()
    {
        if ($this->product_categories->count()) {

            return $this->encodeArrayValue($this->product_categories->lists('name'));
        }

        return '';
    }

    /**
     * Get manufacturer attribute
     * @return string
     */
    public function getManufacturerAttribute()
    {
        return $this->product_manufacturer ? $this->product_manufacturer->name : '';
    }

    /**
     * Get properties attribute
     */
    public function getPropertiesAttribute()
    {
        if ($this->product_properties->count()) {

            $properties = [];

            $this->product_properties->each(function ($property) use (&$properties) {
                $properties[] = $this->encodeArrayValue([$property->code, $this->getPropertyValueById($property->pivot->property_value_id)], '::');
            });

            return $this->encodeArrayValue($properties);
        }

        return '';
    }

    /**
     * Get Binding type code by id
     */
    private function getBindingTypeCodeById($id)
    {
        if (empty($this->bindingTypes)) {
            $this->bindingTypes = BindingType::all();
        }

        if ($bindingType = $this->bindingTypes->find($id)) {
            return $bindingType->code;
        } else {
            return 'default';
        }
    }

    /**
     * Get property value by id
     */
    private function getPropertyValueById($id)
    {
        if (empty($this->propertyValues)) {
            $this->propertyValues = PropertyValue::all();
        }

        if ($propertyValue = $this->propertyValues->find($id)) {
            return $propertyValue->value;
        } else {
            return 'default';
        }
    }
}