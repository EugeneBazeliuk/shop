<?php namespace Djetson\Shop\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Djetson\Shop\Models\Product as ShopProduct;
use Djetson\Shop\Models\Binding as ShopBinding;
use Djetson\Shop\Models\Category as ShopCategory;

/**
 * Class ProductsList
 * @package Djetson\Shop
 */
class ProductsList extends ComponentBase
{
    /**
     * A collection of products to display
     * @var \October\Rain\Database\Collection
     */
    public $products;

    /**
     * @var \Djetson\Shop\Models\Binding
     */
    public $binding;

    /**
     * @var \Djetson\Shop\Models\Category
     */
    public $category;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     *
     * @var string
     */
    public $productPage;

    /**
     * Component details
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'ProductsList Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * Component properties
     * @return array
     */
    public function defineProperties()
    {
        return [
            'bindingFilter'  => [
                'title'       => 'Binding Filter',
                'type'        => 'string',
            ],
            'categoryFilter' => [
                'title'       => 'Category Filter',
                'type'        => 'string',
            ],
            'pageNumber' => [
                'title'       => 'Page number',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'productPage' => [
                'title'       => 'Product Page',
                'type'        => 'dropdown',
                'group'       => 'Links',
            ],
        ];
    }

    //
    // Options
    //

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     *
     */
    public function onRun()
    {
        $this->prepareVars();

        $this->binding = $this->loadCategory();
        $this->category = $this->loadCategory();
        $this->products = $this->loadProducts();
    }

    /**
     *
     */
    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');

        /*
         * Links
         */
        $this->productPage = $this->page['productPage'] = $this->property('productPage');
    }

    /**
     * Load Binding
     * @return \Djetson\Shop\Models\Binding|null
     */
    protected function loadBinding()
    {
        if (!$slug = $this->property('bindingFilter')) {
            return null;
        }

        $binding = ShopBinding::where(['slug' => $slug])->first();

        return $binding ? $binding : null;
    }

    /**
     * Load Category
     * @return \Djetson\Shop\Models\Category|null
     */
    protected function loadCategory()
    {
        if (!$slug = $this->property('categoryFilter')) {
            return null;
        }

        $category = ShopCategory::where(['slug' => $slug])->first();

        return $category ? $category : null;
    }

    /**
     *
     */
    protected function loadProducts()
    {
        $binding = $this->binding ? $this->binding->id : null;
        $category = $this->category ? $this->category->id : null;

        /**
         *
         */
        $products = ShopProduct::listFrontEnd([
            'bindings'      => $binding,
            'categories'    => $category,
            'page'          => $this->property('pageNumber'),
        ]);

        /*
         * Add url
         */
        $products->each(function($product) {
            $product->setUrl($this->productPage, $this->controller);
        });

        return $products;
    }
}