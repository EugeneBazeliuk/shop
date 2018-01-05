<?php namespace Djetson\Shop\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use ApplicationException;

/**
 * Reserve Model
 *
 * @property string             $code
 * @property int                $quantity
 * @property int                $product_id
 * @property int                $author_id
 * @property int                $warehouse_id
 * @property bool               $is_reserved
 * @property bool               $is_expired
 * @property \Carbon\Carbon     $created_at
 * @property \Carbon\Carbon     $updated_at
 * @property \Carbon\Carbon     $reserved_to
 *
 * @property \Backend\Models\User                       $author
 * @property \Djetson\Shop\Models\Product               $product
 * @property \Djetson\Shop\Models\Warehouse             $warehouse
 *
 * @method \October\Rain\Database\Relations\BelongsTo   products
 * @method \October\Rain\Database\Relations\BelongsTo   manager
 * @method \October\Rain\Database\Relations\BelongsTo   warehouse
 *
 * @mixin \Eloquent
 * @mixin \October\Rain\Database\Model
 */
class Reserve extends \October\Rain\Database\Model
{
    use \October\Rain\Database\Traits\Validation;

    public $incrementing = false;
    protected $primaryKey = 'code';

    /** @var string The database table used by the model. */
    public $table = 'djetshop_reserves';

    /** @var array Guarded fields */
    protected $guarded = ['*'];

    /** @var array Dates fields */
    protected $dates = [
        'reserved_to'
    ];

    /** @var array Validation rules */
    public $rules = [
        'product'   => ['required'],
        'warehouse' => ['required'],
        'quantity'  => ['required', 'integer'],
    ];

    /** @var array Relations */
    public $belongsTo = [
        'author' => 'Backend\Models\User',
        'product' => 'Djetson\Shop\Models\Product',
        'warehouse' => 'Djetson\Shop\Models\Warehouse',
    ];

    //
    // Events
    //

    public function beforeCreate()
    {
        $this->reserveProduct();
        $this->setCode();
        $this->setAuthor();
        $this->setReservedTo();
    }

    public function beforeUpdate()
    {
        if ($this->isDirty([$this->product_id, $this->warehouse_id])) {
            throw new ApplicationException('Запрещено менять товар и склад в резерве');
        }
    }

    public function beforeDelete()
    {
        $this->returnProduct();
    }

    //
    // Setter's
    //
    public function getIsExpiredAttribute()
    {
        return $this->reserved_to < Carbon::now();
    }


    //
    // Option's
    //

    public function getWarehouseOptions()
    {
        return $this->product ? $this->product->getWarehousesList() : [];
    }

    //
    // Scope's
    //
    public function scopeIsExpired($query)
    {
        return $query->where('reserved_to', '<', Carbon::now());
    }

    /**
     * Set reserve code
     */
    private function setCode()
    {
        $this->code = strtoupper(str_random(6));
    }

    /**
     * Set Reserve Author
     * @return void
     */
    private function setAuthor()
    {
        $this->author = BackendAuth::getUser();
    }

    /**
     * Set Reserved Time
     * @return void
     * @todo value to settings
     */
    private function setReservedTo()
    {
        $this->reserved_to = Carbon::now()->addMinutes(15);
    }

    /**
     * Reserve Product
     * @throws \ApplicationException
     * @return void
     */
    private function reserveProduct()
    {
        if (!$this->warehouse->takeProduct($this->product_id, $this->quantity)) {
            throw new ApplicationException('Не удалось зарезервировать товар на складе');
        }
    }

    /**
     * Cancel Reserve
     * @throws \ApplicationException
     * @return void
     */
    private function returnProduct()
    {
        if (!$this->warehouse->putProduct($this->product_id, $this->quantity)) {
            throw new ApplicationException('Не удалось вернуть товар на складе');
        }
    }
}