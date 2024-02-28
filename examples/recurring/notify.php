<?php

// Tell Payfast that this page is reachable by triggering a header 200
header('HTTP/1.0 200 OK');
flush();

require_once '../../vendor/autoload.php';

use PayFast\PayFastPayment;

$amount = '5.00';

try {
    $payfast = new PayFastPayment(
        [
            'merchantId'  => '10000100',
            'merchantKey' => '46f0cd694581a',
            'passPhrase'  => 'jt7NOE43FZPn',
            'testMode'    => true
        ]
    );

    $notification = $payfast->notification->isValidNotification($_POST, ['amount_gross' => $amount]);
} catch (Exception $e) {
    // Handle exception
    throw new InvalidArgumentException($e);
}
