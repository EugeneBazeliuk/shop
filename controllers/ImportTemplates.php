<?php namespace Djetson\Shop\Controllers;

use Queue;
use Flash;
use Exception;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * Import Templates Back-end Controller
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 */
class ImportTemplates extends Controller
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
        SettingsManager::setContext('Djetson.Shop', 'import_templates');
        // Add custom css styles
        $this->addCss('/plugins/djetson/shop/assets/css/style.css');
    }

    /**
     * @param $record_id
     */
    public function onRunImport($record_id)
    {



        $job = (new \Djetson\Shop\Jobs\RunProductImport());

        dispatch($job);

//        try {
//            /** @var \Djetson\Shop\Models\ImportTemplate $model */
//            $model = $this->formFindModelObject($record_id);
//            $data = $model->getFileData();
//
//            $pi = new \Djetson\Shop\Models\ProductImport();
//            $pi->importData($data);
//        }
//        catch (Exception $ex) {
//            Flash::error($ex->getMessage());
//        }
    }

    /**
     * Preload File Mapping
     * @param $host
     * @param $data
     */
    public function formExtendRefreshData($host, $data)
    {
        $file = $host->model
            ->file()
            ->withDeferred($this->formGetSessionKey())
            ->orderBy('id', 'desc')
            ->first();

        if (!$file) {
            return;
        }

        $data['mapping'] = $host->model->getFileMapping($file);

        return $data;
    }
}
