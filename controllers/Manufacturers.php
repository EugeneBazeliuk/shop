<?php namespace Djetson\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Djetson\Shop\Models\Manufacturer;

/**
 * Manufacturers Back-end Controller
 */
class Manufacturers extends Controller
{
    public $bodyClass = 'compact-container';

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $requiredPermissions = ['djetson.shop.access_manufacturers'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Djetson.Shop', 'shop', 'manufacturers');
        // Add custom css styles
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
    }

    public function index()
    {
        $this->vars['scoreboard'] = $this->getListScoreboard();
        $this->asExtension('ListController')->index();
    }

    private function getListScoreboard()
    {
        return [
            'enabled_count' => Manufacturer::where('is_active', 1)->count(),
            'disabled_count' => Manufacturer::where('is_active', 0)->count(),
            'deleted_count' =>Manufacturer::onlyTrashed()->count()
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
