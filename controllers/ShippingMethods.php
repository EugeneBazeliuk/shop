<?php namespace Djetson\Shop\Controllers;

use BackendMenu;
use System\Classes\SettingsManager;
use Backend\Classes\Controller;

/**
 * Shipping Methods Back-end Controller
 */
class ShippingMethods extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Djetson.Shop', 'shipping_methods');
        // Add custom css styles
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
    }
}