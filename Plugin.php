<?php namespace Djetson\Shop;

use App;
use Event;
use Backend;
use System\Classes\PluginBase;
use Djetson\Shop\Models\Order;
use Djetson\Shop\Models\Settings;
use Illuminate\Foundation\AliasLoader;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UserController;

/**
 * Shop Plugin Information File
 */
class Plugin extends PluginBase
{
    private $userFormConfig = '$/djetson/shop/config/user_fields.yaml';

    /**
     * Register Plugin Components
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Djetson\Shop\Components\ProductsList'  => 'productsList',
            'Djetson\Shop\Components\ProductView'  => 'productsView',
        ];
    }

    /**
     * Register Plugin Navigation
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'shop' => [
                'label'       => 'djetson.shop::lang.plugin.label',
                'url'         => Backend::url('djetson/shop/orders'),
                'icon'        => 'icon-shopping-cart',
                'permissions' => ['djetson.shop.*'],
                'order'       => 300,

                'sideMenu' => [
                    'orders' => [
                        'label'       => 'djetson.shop::lang.shop.orders',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/orders'),
                        'permissions' => ['djetson.shop.access_orders'],
                        'counter'     => Order::isNew()->count() ?: null,
                    ],
                    'products' => [
                        'label'       => 'djetson.shop::lang.shop.products',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/products'),
                        'permissions' => ['djetson.shop.access_products'],
                    ],
                    'categories' => [
                        'label'       => 'djetson.shop::lang.shop.categories',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/categories'),
                        'permissions' => ['djetson.shop.access_categories'],
                    ],
                    'manufacturers' => [
                        'label'       => 'djetson.shop::lang.shop.manufacturers',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/manufacturers'),
                        'permissions' => ['djetson.shop.access_manufacturers'],
                    ],
                    'bindings' => [
                        'label'       => 'djetson.shop::lang.shop.bindings',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/bindings'),
                        'permissions' => ['djetson.shop.access_bindings'],
                    ],
                    'warehouses' => [
                        'label'       => 'djetson.shop::lang.shop.warehouses',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/warehouses'),
                        'permissions' => ['djetson.shop.access_warehouses'],
                    ],
                    'reserves' => [
                        'label'       => 'djetson.shop::lang.shop.reserves',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/reserves'),
                        'permissions' => ['djetson.shop.access_reserves'],
                    ],
                    'importtasks' => [
                        'label'       => 'djetson.shop::lang.shop.import_tasks',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('djetson/shop/importtasks'),
                        'permissions' => ['djetson.shop.access_imports'],
                    ],
                ]
            ]
        ];
    }

    /**
     * On boot Plugin
     * @return void
     */
    public function boot()
    {
        $this->extentRainlabUserPlugin();
        $this->registerDomPdf();
    }

    /**
     * On register plugin
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('djetshop:import', 'Djetson\Shop\Console\Import');
        $this->registerConsoleCommand('djetshop:reservecheck', 'Djetson\Shop\Console\ReserveCheck');
    }

    /**
     * Register List Column Types
     * @return array
     */
    public function registerListColumnTypes()
    {
        return [
            'price' => function($value) {
                return Settings::getFormattedPrice($value);
            },
            'label' => [$this, 'evalLabelListColumn'],
            'switch_colored' => [$this, 'evalSwitchColoredListColumn']
        ];
    }

    /**
     * @param $value
     * @param $column
     * @param $record
     *
     * @return string
     */
    public function evalLabelListColumn($value, $column, $record)
    {
        return sprintf('<span class="btn btn-label" style="background: %s">%s</span>', $record->color, $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function evalSwitchColoredListColumn($value)
    {
        return sprintf('<span class="oc-icon-circle %s">', $value ? 'text-success' : 'text-danger');
    }

    /**
     *
     */
    private function registerDomPdf()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('PDF', 'Barryvdh\DomPDF\Facade');

        App::register('Barryvdh\DomPDF\ServiceProvider');
    }

    /**
     * Extend Rainlab.User Plugin
     */
    private function extentRainlabUserPlugin()
    {
        // Extend Rainlab.User model
        UserModel::extend(function(UserModel $model) {

            // Add HasMany Orders
            $model->hasMany['orders'] = [
                'Djetson\Shop\Models\Order',
                'key' => 'customer_id'
            ];

            // Add Location Implementation
            $model->implement[] = 'RainLab.Location.Behaviors.LocationModel';
        });

        // Extend Rainlab.User controller
        UserController::extend(function (UserController $controller) {

            if (!$controller->isClassExtendedWith('Backend.Behaviors.RelationController')) {
                $controller->implement[] = 'Backend.Behaviors.RelationController';
            }

            if (!isset($controller->relationConfig)) {
                $controller->addDynamicProperty('relationConfig');
            }

            $relationConfig = '$/djetson/shop/controllers/users/config_relation.yaml';

            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $relationConfig
            );
        });

        // Extend Rainlab.User Fields
        Event::listen('backend.form.extendFields', function(\Backend\Widgets\Form $widget) {

            if (!$widget->getController() instanceof UserController) {
                return;
            }

            if (!$widget->model instanceof UserModel) {
                return;
            }

            $config = $widget->makeConfig($this->userFormConfig);

            $widget->addTabFields($config->fields);
        });
    }
}