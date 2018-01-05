<?php namespace Djetson\Shop\Console;

use Illuminate\Console\Command;
use Djetson\Shop\Jobs\ProductImport;
use Djetson\Shop\Models\Settings;
use Djetson\Shop\Models\ImportTemplate;

/**
 * Class Import
 * @package Djetson\Shop\Console
 * @todo Сделать обработку ошибок
 */
class Import extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'djetshop:import';

    /**
     * @var string The console command description.
     */
    protected $description = 'Product Import';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $file = $this->getImportFile();
        $template = $this->getImportTemplate();

        dispatch(new ProductImport($file, $template));
    }

    /**
     * Get import File
     * @return \System\Models\File
     */
    private function getImportFile()
    {
        $path = $this->getMediaFilePath(Settings::get('import_file', null));

        $file = new \System\Models\File;
        $file->fromFile($path);

        return $file;
    }

    /**
     * Get Import Template
     * @return mixed
     */
    private function getImportTemplate()
    {
        return ImportTemplate::findOrFail(Settings::get('import_template_id', null));
    }

    /**
     * Get Media file path
     * @param $path
     * @return string
     */
    private function getMediaFilePath($path)
    {
        return base_path(config('cms.storage.media.path').$path);
    }
}
