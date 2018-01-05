<?php namespace Djetson\Shop\Controllers;

use Flash;
use Exception;
use BackendMenu;
use Backend\Classes\Controller;
use Djetson\Shop\Models\ImportTask;

/**
 * Import Tasks Back-end Controller
 *
 * @property \Backend\Widgets\Form $importTaskFormWidget
 *
 * @mixin \Backend\Behaviors\FormController
 * @mixin \Backend\Behaviors\ListController
 */
class ImportTasks extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['djetson.shop.access_import_tasks'];

    protected $importTaskFormWidget;

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Djetson.Shop', 'shop', 'importtasks');
        $this->importTaskFormWidget = $this->createImportTaskFormWidget();
    }

    //
    // TASK WIDGET
    //

    /**
     * CreateTask FormWidget
     * @return \Backend\Classes\WidgetBase
     */
    private function createImportTaskFormWidget()
    {
        $config = $this->makeConfig('$/djetson/shop/models/importtask/fields.yaml');
        $config->alias = 'importTaskForm';
        $config->arrayName = 'ImportTask';
        $config->context = 'create';
        $config->model = new ImportTask;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $widget;
    }

    /**
     * Handler load createImportTask Form
     * @return mixed
     */
    public function index_onLoadCreateImportTaskForm()
    {
        $this->vars['importTaskWidget'] = $this->importTaskFormWidget;
        return $this->makePartial('form_create_import_task');
    }

    /**
     * Handler on Create ImportTask
     * @return array
     */
    public function index_onCreateImportTask()
    {
        try {
            $data = $this->importTaskFormWidget->getSaveData();
            $model = new ImportTask;
            $model->fill($data);
            $model->save(null, $this->importTaskFormWidget->getSessionKey());

            Flash::success(trans('djetson.shop::lang.import_tasks.create_success'));
        }
        catch (Exception $ex) {
            Flash::error($ex->getMessage());
        }

        return $this->listRefresh();
    }
}
