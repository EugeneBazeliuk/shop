<?php namespace Djetson\Shop\Models;

use Carbon\Carbon;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;
use Djetson\Shop\Jobs\ProductImport;

/**
 * ImportTask Model
 *
 * @property int                $id
 * @property int                $template_id
 * @property int                $progress
 * @property string             $status
 * @property string             $details
 * @property \Carbon\Carbon     $done_at
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 *
 * @property \System\Models\File $file
 * @property \Djetson\Shop\Models\ImportTemplate $template
 *
 * @method \October\Rain\Database\Relations\AttachOne file
 * @method \October\Rain\Database\Relations\BelongsTo template
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Traits\Validation
 */
class ImportTask extends Model
{
    use Validation;

    const STATUS_DONE       = 'done';
    const STATUS_FAILED     = 'failed';
    const STATUS_WAITING    = 'waiting';
    const STATUS_PROGRESS   = 'in_progress';

    /** @var string The database table used by the model. */
    public $table = 'djetshop_import_tasks';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Fillable fields */
    protected $fillable = [
        'file',
        'template'
    ];

    /** @var array Dates fields */
    protected $dates = [
        'done_at'
    ];

    /** @var array */
    protected $jsonable = [
        'details'
    ];

    /** @var array Relations BelongTo */
    public $belongsTo = [
        'template' => [
            'Djetson\Shop\Models\ImportTemplate',
        ],
    ];

    /** @var array Relations AttachOne */
    public $attachOne = [
        'file' => 'System\Models\File',
    ];

    /** @var array Validation rules */
    public $rules = [
        'file' => ['required'],
        'template' => ['required'],
    ];

    //
    // Event's
    //
    public function beforeCreate()
    {
        $this->status = self::STATUS_WAITING;
    }

    public function afterCreate()
    {
        $this->addImportJob();
    }

    //
    // Setter's
    //
    public function getStatusAttribute($value)
    {
        return trans(sprintf('djetson.shop::lang.import_task.status_%s', $value));
    }

    //
    //
    //

    /**
     * Mark as in progress
     * @return void
     */
    public function inProgress()
    {
        $this->updateStatus(self::STATUS_PROGRESS);
        $this->save();
    }

    /**
     * Mark as Done
     * @param $details
     * @return void
     */
    public function isDone($details)
    {
        $this->updateDoneTimestamp();
        $this->updateStatus(self::STATUS_DONE);
        $this->details = $details;
        $this->save();
    }

    /**
     * Mark as Failed
     * @return void
     */
    public function isFailed()
    {
        $this->updateDoneTimestamp();
        $this->updateStatus(self::STATUS_FAILED);
        $this->save();
    }

    /**
     * Get import Data
     * @return array
     */
    public function getImportData()
    {
        return $this->template->getData($this->file);
    }

    /**
     * Update done timestamp
     */
    private function updateDoneTimestamp()
    {
        $this->done_at = Carbon::now();
    }

    /**
     * Update ImportTask Status
     * @param $status
     */
    private function updateStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Start Import Job
     * @return void
     */
    private function addImportJob()
    {
        dispatch(new ProductImport($this));
    }
}
