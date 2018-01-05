<?php namespace Djetson\Shop\Models;

/**
 * Product Model
 * @package Djetson\Shop
 */
class ProductImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    protected $bindingCache = [];
    protected $bindingTypeCache = [];
    protected $categoryCache = [];
    protected $manufacturerCache = [];
    protected $propertyCache = [];
    protected $propertyValueCache = [];

    public function importData($results, $sessionKey = null)
    {
        //
        // Import
        //
        foreach ($results as $row => $data) {
            try {

                // Check Name
                if (!$name = array_get($data, 'name')) {
                    $this->logSkipped($row, 'Missing product name');
                    continue;
                };

                // Check Name
                if (!$sku = array_get($data, 'sku')) {
                    $this->logSkipped($row, 'Missing product sku');
                    continue;
                };

                // Find or create
                $product = Product::make();
                $product = $this->findDuplicateProduct($data) ?: $product;
                $productExists  = $product->exists;

                // Set attributes
                $except = ['id', 'bindings', 'category', 'categories', 'manufacturer', 'properties'];

                foreach (array_except($data, $except) as $attribute => $value) {
                    $product->{$attribute} = $value ?: null;
                }

                // Set manufacturer
                if (array_get($data, 'manufacturer')) {
                    $product->manufacturer = $this->getManufacturerId($data);
                }

                // Save
                $product->save();

                // Sync bindings
                if (array_get($data, 'bindings')) {
                    $product->bindings()->sync($this->getBindingsIds($data), false);
                }

                // Sync categories
                if (array_get($data, 'categories')) {
                    $product->categories()->sync($this->getCategoriesIds($data), false);
                }

                // Sync properties
                if ($properties = array_get($data, 'properties')) {
                    $product->properties()->sync($this->getPropertiesIds($properties), false);
                }

                //
                // Log results
                //
                if ($productExists) {
                    $this->logUpdated();
                }
                else {
                    $this->logCreated();
                }
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function findDuplicateProduct($data)
    {
        return array_get($data, 'id')
            ? Product::find(array_get($data, 'id'))
            : Product::where('sku', array_get($data, 'sku'))->first();
    }

    /**
     * Get Bindings Ids
     * @return array
     */
    private function getBindingsIds($data)
    {
        $ids = [];
        $bindings = $this->decodeArrayValue(array_get($data, 'bindings'));

        foreach ($bindings as $binding) {
            $binding = explode('::', $binding);
            $type = $binding[0];
            $name = $binding[1];

            $model = Binding::firstOrCreate([
                'name' => $name,
                'type_id' => $this->getBindingTypeId($type)
            ]);

            $ids[] = $this->bindingCache[$type][$name] = $model->id;
        }

        return $ids;
    }

    /**
     * Get BindingType ID by code
     * @param $code
     * @return int
     */
    private function getBindingTypeId($code)
    {
        if (isset($this->bindingTypeCache[$code])) {
            return $this->bindingTypeCache[$code];
        } elseif ($model = BindingType::where('code', $code)->first()) {
            return $this->bindingTypeCache[$code] = $model->id;
        } else {
            $model = BindingType::create(['name' => $code, 'code' => $code]);
            return $model->id;
        }
    }

    /**
     * Get Categories Ids
     * @param array $data
     * @return array
     */
    private function getCategoriesIds($data)
    {
        $ids = [];
        $categories = $this->decodeArrayValue(array_get($data, 'categories'));

        foreach ($categories as $name) {
            if (isset($this->categoryCache[$name])) {
                $ids[] = $this->categoryCache[$name];
            } else {
                $newCategory = Category::firstOrCreate(['name' => $name]);
                $ids[] = $this->categoryCache[$name] = $newCategory->id;
            }
        }

        return $ids;
    }

    /**
     * Get Manufacturer ID
     * @param array $data
     * @return mixed
     */
    private function getManufacturerId($data)
    {
        $name = array_get($data, 'manufacturer');

        if (isset($this->manufacturerCache[$name])) {
            return $this->manufacturerCache[$name];
        } else {
            $model = Manufacturer::firstOrCreate(['name' => $name]);
            return $this->manufacturerCache[$name] = $model->id;
        }
    }

    /**
     *
     */
    private function getPropertiesIds($properties)
    {
        $ids = [];
        $properties = $this->decodeArrayValue($properties);

        foreach ($properties as $property) {
            $property = $this->decodeArrayValue($property, '::');
            $code = $property[0];
            $value = $property[1];

            if (isset($this->propertyCache[$code])) {
                $id = $this->propertyCache[$code];
            } else {
                $model = Property::firstOrCreate(['code' => $code]);
                $id = $this->propertyCache[$code] = $model->id;
            }

            $ids[$id] = ['property_value_id' => $this->getPropertyValueId($id, $value)];
        }

        return $ids;
    }

    private function getPropertyValueId($propertyId, $value)
    {
        if (isset($this->propertyValueCache[$propertyId][$value])) {
            return $this->propertyValueCache[$propertyId][$value];
        } else {
            $model = PropertyValue::firstOrCreate(['property_id' => $propertyId, 'value' => $value]);
            return $this->propertyValueCache[$propertyId][$value] = $model->id;
        }
    }
}