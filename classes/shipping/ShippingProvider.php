<?php namespace Djetson\Shop\Classes\Shipping;

use ApplicationException;

/**
 * Class ShippingProvider
 * @package Djetson\Shop
 */
abstract class ShippingProvider
{
    protected $code;

    public static function getInstance(string $providerCode)
    {
        switch ($providerCode)
        {
            default:
                throw new ApplicationException('Provider error');
        }
    }
}