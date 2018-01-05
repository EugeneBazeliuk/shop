<?php namespace Djetson\Shop\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Reserves Back-end Controller
 */
class Reserves extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController'
    ];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Djetson.Shop', 'shop', 'reserves');
    }
}
