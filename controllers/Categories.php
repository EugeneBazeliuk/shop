<?php namespace Djetson\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Djetson\Shop\Models\Category;

/**
 * Categories Back-end Controller
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 * @mixin \Backend\Behaviors\ReorderController
 */
class Categories extends Controller
{
    public $bodyClass = 'compact-container';

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['djetson.shop.access_categories'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Djetson.Shop', 'shop', 'categories');
        // Add custom css styles
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
    }

    public function reorder()
    {
        $this->bodyClass = '';
        $this->asExtension('ReorderController')->reorder();
    }

    public function index()
    {
        $this->vars['scoreboard'] = $this->getListScoreboard();
        $this->asExtension('ListController')->index();
    }

    private function getListScoreboard()
    {
        return [
            'enabled_count' => Category::where('is_active', 1)->count(),
            'disabled_count' => Category::where('is_active', 0)->count(),
            'deleted_count' =>Category::onlyTrashed()->count()
        ];
    }

    /**
     * @param \Djetson\Shop\Models\Category $query
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }
}