<?php namespace Djetson\Shop\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * ReserveItems Form Widget
 */
class ReserveItems extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'djetson_shop_reserve_items';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('reserveitems');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/reserveitems.css', 'djetson.shop');
        $this->addJs('js/reserveitems.js', 'djetson.shop');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        $item = \Djetson\Shop\Models\OrderItem::make([
            'product' => 1,
            'warehouse' => 1,
            'price' => 100,
            'quantity' => 1
        ]);

        $collection = collect($item);

        return 'asd';
    }
}
