<?php namespace Djetson\Shop\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Djetson\Shop\Models\ImportTask;
use Djetson\Shop\Models\ProductImport as ProductImportModel;

/**
 * Class ProductImport
 * @package Djetson\Shop\Jobs
 * @todo Написать защиту от повторного исполнения
 */
class ProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    private $task;

    /**
     * RunProductImport constructor.
     * @param \Djetson\Shop\Models\ImportTask $task
     */
    public function __construct(ImportTask $task)
    {
        $this->task = $task;
    }

    /**
     * Fire handler
     * @return void
     */
    public function handle()
    {
        $this->task->inProgress();
        $data = $this->task->getImportData();

        $productImport = new ProductImportModel();
        $productImport->importData($data);

        $results = $productImport->getResultStats();

        $this->task->isDone($results);
    }

    /**
     * Failed handler
     * @param \Exception $ex
     */
    public function failed(Exception $ex)
    {
        $this->task->isFailed();
    }
}