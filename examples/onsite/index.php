<?php

require_once '../../vendor/autoload.php';

use PayFast\PayFastPayment;

$amount = '5.00';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://www.payfast.co.za/onsite/engine.js"></script>
</head>
<body>

<div class='subject'>Checkout&nbsp;&nbsp;Check<br>Checkout&nbsp;&nbsp;Check</div>

<div class='checkout'>
    <div class='order'>
        <h2>Onsite Checkout Demo</h2>
        <form method="post" action="index.php">
            <h5>Merchant ID:</h5>
            <div class="input-wrapper">
                <input name="merchantId" id="price" type="text" value="">
            </div>
            <h5>Merchant Key:</h5>
            <div class="input-wrapper">
                <input name="merchantKey" id="price" type="text" value="">
            </div>
            <h5>Passphrase:</h5>
            <div class="input-wrapper">
                <input name="passPhrase" id="price" type="text" value="">
            </div>
            <input type="submit" class="button-cta" name="paynow" value="PAY NOW">
        </form>

    </div>
</div>

<?php
if (isset($_POST['paynow'])) {
    try {
        $payfast = new PayFastPayment(
            [
                'merchantId'  => $_POST['merchantId'], // Your merchant id
                'merchantKey' => $_POST['merchantKey'], // Your merchant key
                'passPhrase'  => $_POST['passPhrase'],
                'testMode'    => false
            ]
        );

        $data = [
            // Merchant details
            'return_url'    => 'https://yoursite.com/return.php', // Requires HTTPS
            'cancel_url'    => 'https://yoursite.com/cancel.php', // Requires HTTPS
            'notify_url'    => 'https://yoursite.com/notify.php', // Requires HTTPS
            // Buyer details
            'name_first'    => 'First Name',
            'name_last'     => 'Last Name',
            'email_address' => 'test@test.com',
            // Transaction details
            'm_payment_id'  => '1234', //Unique payment ID to pass through to notify_url
            'amount'        => $amount,
            'item_name'     => 'Order#123'
        ];

        // Generate payment identifier
        $identifier = $payfast->onsite->generatePaymentIdentifier($data);

        if ($identifier !== null) {
            echo '<script type="text/javascript">
                    window.payfast_do_onsite_payment({"uuid":"' . $identifier . '"});
                  </script>';
        }
    } catch (Exception $e) {
        echo 'There was an exception: ' . $e->getMessage();
    }
}
?>

</body>
</html>

