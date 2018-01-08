<?php namespace Djetson\Shop\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Djetson\Shop\Models\Product as ShopProduct;

/**
 * Class ProductView
 * @package Djetson\Shop\Components
 */
class ProductView extends ComponentBase
{
    /**
     * @var ShopProduct The product model used for display
     */
    public $product;

    /**
     * @var array
     */
    public $productProperties = [];

    /**
     * @var array
     */
    public $productBindings = [];

    /**
     * @var string
     */
    public $bindingPage;


    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'ProductView',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'bindingPage' => [
                'title'       => 'Binding',
                'type'        => 'dropdown',
                'default'     => 'shop/bindings',
            ],
        ];
    }

    //
    // Options
    //
    public function getBindingPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    //
    //
    //

    /**
     *
     */
    public function onRun()
    {
        $this->bindingPage = $this->property('bindingPage');

        $this->product = $this->page['product'] = $this->loadProduct();
        $this->productProperties = $this->loadProperties();
        $this->productBindings = $this->loadBindings();
    }

    /**
     * Load Product
     */
    protected function loadProduct()
    {
        $product = ShopProduct::with(['bindings.type', 'properties'])
            ->where('slug', $this->property('slug'))
            ->first();

        /*
         * Add a URL helper attribute for bindings
         */
        if ($product && $product->bindings->count()) {
            $product->bindings->each(function($binding) {
                $binding->setUrl($this->bindingPage, $this->controller);
            });
        }

        return $product;
    }

    /**
     * @todo Оптимизировать загрузку pivot модели @var $value
     */
    protected function loadProperties()
    {
        $properties = [];

        if ($this->product && $this->product->properties->count()) {
            $this->product->properties->each(function($property) use (&$properties) {
                array_push($properties, [
                    'name' => $property->code,
                    'value' => $property->pivot->getValue()
                ]);
            });
        }

        return $properties;
    }

    /**
     *
     * @return array
     */
    protected function loadBindings()
    {
        $bindings = [];

        if ($this->product && $this->product->bindings->count()) {
            $this->product->bindings->each(function ($binding) use (&$bindings) {

                if (!array_key_exists($binding->type->code, $bindings)) {
                    $bindings[$binding->type->code] = [
                        'type' => $binding->type->name,
                        'items' => []
                    ];
                }

                $bindings[$binding->type->code]['items'][] = ['name' => $binding->name, 'url'=> $binding->url];
            });
        }

        return $bindings;
    }
}
