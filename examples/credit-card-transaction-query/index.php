<?php
require_once '../../vendor/autoload.php';

use Payfast\PayFastApi;

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

        <?php
        if(isset($_POST['paynow'])) {
            try {
                $api = new PayFastApi(
                    [
                        'merchantId' => '10000100',
                        'passPhrase' => '46f0cd694581a',
                        'testMode' => true
                    ]
                );

                $creditCardArray = $api->creditCardTransactions->fetch('b0ea1afa-f04e-4d3e-9d65-7eeeb38b1dfe');
                echo '<div id="view">' . print_r($creditCardArray, true) . '</div>';

            } catch(Exception $e) {
                echo 'There was an exception: '.$e->getMessage();
            }
        }
        ?>
        <form method="post" action="index.php">
            <input type="submit" class="button-cta" name="paynow" value="View Credit Card Transaction Query">
        </form>

    </div>
</div>

</body>
</html>
