<?php


namespace Payfast;

use Payfast\PaymentIntegrations\CustomIntegration;
use Payfast\PaymentIntegrations\Notification;
use Payfast\PaymentIntegrations\OnsiteIntegration;
use Payfast\Services\CreditCardTransactions;
use Payfast\Services\Refunds;
use Payfast\Services\Subscriptions;
use Payfast\Services\TransactionHistory;

class ServiceMapper
{

    private static $map = [
        'custom' => CustomIntegration::class,
        'onsite' => OnsiteIntegration::class,
        'notification' => Notification::class,
        'transactionHistory' => TransactionHistory::class,
        'subscriptions' => Subscriptions::class,
        'creditCardTransactions' => CreditCardTransactions::class,
        'refunds' => Refunds::class
    ];

    public static function getClass($name)
    {
        return self::$map[$name] ?? null;
    }

}
