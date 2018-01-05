<?php namespace Djetson\Shop\Classes\Import;

/**
 * Class Payments Provider
 * @package Djetson\Shop
 */
abstract class ImportProvider
{
    protected $content;

    /**
     * ImportProvider constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->content = $this->loadFileContent($path);
    }

    /**
     * @param \System\Models\File $file
     *
     * @return object|null
     */
    public static function getInstance($file)
    {
        if (!$file instanceof \System\Models\File) {
            return null;
        }

        switch ($extension = $file->getExtension())
        {
            case 'xml':
                return new ImportProviderXml($file->getLocalPath());
                break;
            default:
                return null;
        }
    }

    /**
     * Load file content
     * @param $path
     *
     * @return mixed
     */
    abstract public function loadFileContent($path);

    /**
     * Get file mapping
     * @return array
     */
    abstract public function getFileMapping();

    /**
     * Get file row
     * @return array
     */
    abstract public function getFileRow();

    /**
     * Get file data
     * @return array
     */
    abstract public function getFileData();
}