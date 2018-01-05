<?php namespace Djetson\Shop\Classes\Import;

/**
 * @val /SimpleXMLElement $content
 * @package Djetson\Shop
 */
class ImportProviderXml extends ImportProvider
{
    public function loadFileContent($path)
    {
        return @simplexml_load_file($path, 'SimpleXMLElement', LIBXML_COMPACT);
    }

    public function getFileMapping()
    {
        $data = [];

        foreach ($this->getFileRow() as $key => $val) {
            $data[] = [
                'key' => $key,
                'val' => trim((string) $val),
            ];
        }

        return $data;
    }

    public function getFileRow()
    {
        $data = [];

        if ($this->content->count()) {
            foreach ($this->content->children()[0] as $key => $val) {
                $data[$key] = trim((string) $val);
            }
        }

        return $data;
    }

    public function getFileData()
    {
        $i = 0;
        $data = [];

        if ($this->content->count()) {
            foreach ($this->content as $item) {
                foreach ($item as $k => $v) {
                    $data[$i][$k] = trim((string) $v);
                }
                $i++;
            }
        }

        return $data;
    }
}