<?php namespace Djetson\Shop\Controllers;

use BackendMenu;
use Carbon\Carbon;
use Backend\Classes\Controller;
use Djetson\Shop\Models\Product;

/**
 * Products Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\RelationController
 * @mixin \Backend\Behaviors\ImportExportController
 */
class Products extends Controller
{
    public $bodyClass = 'compact-container';

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public $requiredPermissions = ['djetson.shop.access_product'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Djetson.Shop', 'shop', 'products');
        // Add custom css styles
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
    }

    public function index()
    {
        $this->listInitScoreboard();
        $this->asExtension('ListController')->index();
    }


    private function listInitScoreboard()
    {
        $this->vars['scoreboard'] = [
            'enabled_count' => Product::where('is_active', 1)->count(),
            'disabled_count' => Product::where('is_active', 0)->count(),
            'deleted_count' => Product::onlyTrashed()->count(),
        ];
    }

    /**
     * @param \Djetson\Shop\Models\Product $query
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }
}