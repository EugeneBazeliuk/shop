<?php namespace Djetson\Shop\Classes\Payment;

use ApplicationException;

/**
 * Class Payments Provider
 * @package Djetson\Shop
 */
abstract class PaymentProvider
{
    public static function getInstance(string $providerCode)
    {
        switch ($providerCode)
        {
            default:
                throw new ApplicationException('Provider error');
        }
    }
}
