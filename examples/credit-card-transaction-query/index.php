<?php

require_once '../../vendor/autoload.php';

use PayFast\PayFastApi;

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
        <h2>Credit Card Transaction Query</h2>

        <form method="post" action="index.php">
            <h5>Merchant ID:</h5>
            <div class="input-wrapper">
                <input name="merchantId" id="price" type="text" value="">
            </div>
            <h5>Passphrase:</h5>
            <div class="input-wrapper">
                <input name="passPhrase" id="price" type="text" value="">
            </div>
            <h5>Subcription Token:</h5>
            <div class="input-wrapper">
                <input name="token" id="price" type="text" value="">
            </div>
            <input type="submit" class="button-cta" name="paynow" value="View Credit Card Transaction Query">
        </form>

        <?php
        if (isset($_POST['paynow'])) {
            try {
                $api = new PayFastApi(
                    [
                        'merchantId' => $_POST['merchantId'],
                        'passPhrase' => $_POST['passPhrase'],
                        'testMode'   => true
                    ]
                );

                $creditCardArray = $api->creditCardTransactions->fetch($_POST['token']);
                echo '<div id="view">' . print_r($creditCardArray, true) . '</div>';
            } catch (Exception $e) {
                echo 'There was an exception: ' . $e->getMessage();
            }
        }
        ?>
    </div>
</div>

</body>
</html>
