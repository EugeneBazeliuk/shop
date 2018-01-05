<?php namespace Djetson\Shop\Models;

use Model;
use ApplicationException;
use October\Rain\Database\Traits\Validation;
use Djetson\Shop\Classes\Import\ImportProvider;

/**
 * ImportTemplate Model
 *
 * @property int        $id
 * @property string     $name
 * @property string     $description
 * @property array      $mapping
 * @property boolean    $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \System\Models\File $file
 * @method \October\Rain\Database\Relations\AttachOne file
 *
 * @mixin \Eloquent
 */
class ImportTemplate extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'djetshop_import_templates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'mapping',
        'description',
        'is_active'
    ];

    /**
     * @var array Json fields
     */
    protected $jsonable  = ['mapping'];

    public $attachOne = [
        'file' => ['System\Models\File']
    ];

    /**
     * Validation
     */
    public $rules = [
        'name'      => ['required', 'between:1,255'],
        'mapping'   => ['required'],
        'is_active' => ['boolean'],
    ];

    //
    // Options
    //
    public function getDataTableOptions()
    {
        return [
            '' => '...',
            'name'              => trans('djetson.shop::lang.form.name'),
            'slug'              => trans('djetson.shop::lang.form.slug'),
            'description'       => trans('djetson.shop::lang.form.description'),
            'sku'               => trans('djetson.shop::lang.form.sku'),
            'isbn'              => trans('djetson.shop::lang.form.isbn'),
            'price'             => trans('djetson.shop::lang.form.price'),
            'package_width'     => trans('djetson.shop::lang.form.package_width'),
            'package_height'    => trans('djetson.shop::lang.form.package_height'),
            'package_depth'     => trans('djetson.shop::lang.form.package_depth'),
            'package_weight'    => trans('djetson.shop::lang.form.package_weight'),
            'meta_title'        => trans('djetson.shop::lang.form.meta_title'),
            'meta_keywords'     => trans('djetson.shop::lang.form.meta_keywords'),
            'meta_description'  => trans('djetson.shop::lang.form.meta_description'),
            'properties'        => trans('djetson.shop::lang.form.properties'),
            'bindings'          => trans('djetson.shop::lang.form.bindings'),
            'manufacturer'      => trans('djetson.shop::lang.form.manufacturer'),
            'category'          => trans('djetson.shop::lang.form.category'),
            'categories'        => trans('djetson.shop::lang.form.categories'),
            'is_active'         => trans('djetson.shop::lang.form.is_active'),
            'is_searchable'     => trans('djetson.shop::lang.form.is_searchable'),
            'is_unique_text'    => trans('djetson.shop::lang.form.is_unique_text'),
        ];
    }

    /**
     * Get file Data
     * @return array
     */
    public function getFileData()
    {
        return $this->getData($this->file);
    }

    /**
     * Get data
     * @param \System\Models\File $file
     * @return array
     */
    public function getData($file)
    {
        $i = 0;
        $data = [];
        $mapping = [];
        $fileData = $this->getFileProvider($file)->getFileData();

        foreach ($this->mapping as $map) {
            if (isset($map['column']) && !empty($map['column'])) {
                $mapping[] = $map;
            }
        }

        foreach ($fileData as $item) {
            foreach ($mapping as $map) {

                if (empty($item[$map['key']])) {
                    continue;
                }

                switch ($map['column']) {
                    case 'bindings':
                    case 'properties':
                        if (isset($data[$i][$map['column']])) {
                            $data[$i][$map['column']] = implode('|', [$data[$i][$map['column']], implode('::', [$map['key'], $item[$map['key']]])]);
                        } else {
                            $data[$i][$map['column']] = implode('::', [$map['key'], $item[$map['key']]]);
                        }
                        break;
                    case 'categories':
                        if (isset($data[$i][$map['column']])) {
                            $data[$i][$map['column']] = implode('|', [$data[$i][$map['column']], $item[$map['key']]]);
                        } else {
                            $data[$i][$map['column']] = $item[$map['key']];
                        }
                        break;
                    default:
                        $data[$i][$map['column']] = $item[$map['key']];
                }
            }
            $i++;
        }

        return $data;
    }

    /**
     * Get file mapping
     * @param $file
     */
    public function getFileMapping($file)
    {
        return $this->getFileProvider($file)->getFileMapping();
    }

    /**
     * Get import provider
     * @param \System\Models\File $file
     *
     * @return object
     * @throws \ApplicationException
     */
    private function getFileProvider($file)
    {
        if ($provider = ImportProvider::getInstance($file)) {
            return $provider;
        } else {
            throw new ApplicationException('Не удалось загрузить провайдер для файла');
        }
    }
}