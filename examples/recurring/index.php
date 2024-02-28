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
        <form method="post" action="index.php">
            <h2>Recurring Checkout Demo</h2>
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
            <h5>Subscription Amount:</h5>
            <div class="input-wrapper">
                <input name="amount" id="price" type="text" value="">
            </div>
            <br>
            <label>
                <h5>Select Option:</h5>
                <div class="input-wrapper">
                    <select name="apiRequest">
                        <option value="">Select Option</option>
                        <option value="fetch">Fetch</option>
                        <option value="pause">Pause</option>
                        <option value="unpause">UnPause</option>
                        <option value="cancel">Cancel</option>
                        <option value="update">Update</option>
                        <option value="adhoc">Adhoc</option>
                    </select>
                </div>
            </label>
            <input type="submit" class="button-cta" name="paynow" value="Send Request to Sandbox">
        </form>

        <?php
        if (isset($_POST['paynow'])) {
            try {
                $api   = new PayFastApi(
                    [
                        'merchantId' => $_POST['merchantId'],
                        'passPhrase' => $_POST['passPhrase'],
                        'testMode'   => true
                    ]
                );
                $token = $_POST['token'];

                switch ($_POST['apiRequest']) {
                    case 'fetch':
                        $fetchArray = $api->subscriptions->fetch($token);
                        if ($updateArray['status'] == 'success') {
                            echo '<script>alert("Fetch Subscription!");</script>';
                        } else {
                            echo '<script>alert("Failed to Fetch Subscription!");</script>';
                        }
                        break;
                    case 'pause':
                        $pauseArray = $api->subscriptions->pause($token, ['cycles' => 1]);
                        if ($pauseArray['status'] == 'success') {
                            echo '<script>alert("Subscription Paused!");</script>';
                        } else {
                            echo '<script>alert("Failed to Pause Subscription!");</script>';
                        }
                        break;
                    case 'unpause':
                        $unpauseArray = $api->subscriptions->unpause($token);
                        if ($unpauseArray['status'] == 'success') {
                            echo '<script>alert("Subscription Unpaused!");</script>';
                        } else {
                            echo '<script>alert("Failed to Unpause Subscription!");</script>';
                        }
                        break;
                    case 'cancel':
                        $cancelArray = $api->subscriptions->cancel($token);
                        if ($cancelArray['status'] == 'success') {
                            echo '<script>alert("Subscription Cancelled!");</script>';
                        } else {
                            echo '<script>alert("Failed to Cancel Subscription!");</script>';
                        }
                        break;
                    case 'update':
                        $updateArray = $api->subscriptions->update($token, [
                            'cycles'    => 14,
                            'frequency' => 4,
                            'amount'    => $_POST['amount'] * 100
                        ]);
                        if ($updateArray['status'] == 'success') {
                            echo '<script>alert("Amount Updated!");</script>';
                        } else {
                            echo '<script>alert("Amount Not Updated!");</script>';
                        }
                        break;
                    case 'adhoc':
                        $adhocArray = $api->subscriptions->adhoc('290ac9a6-25f1-cce4-5801-67a644068818', [
                            'amount'    => isset($_POST['amount']) * 100,
                            'item_name' => 'Test adhoc'
                        ]);
                        if ($adhocArray['status'] == 'success') {
                            echo '<script>alert("Adhoc Updated!");</script>';
                        } else {
                            echo '<script>alert("Adhoc Not Updated!");</script>';
                        }
                        break;
                    case '':
                        echo '<script>alert("Please Select an Option from the Dropdown!");</script>';
                        break;
                    default:
                        break;
                }
            } catch (Exception $e) {
                echo 'There was an exception: ' . $e->getMessage();
            }
        }
        ?>

    </div>
</div>

</body>
</html>

