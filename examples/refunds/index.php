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
        <h2>Onsite Checkout Demo</h2>
        <h5>Order #000001</h5>
        <ul class='order-list'>
            <li><img src='https://via.placeholder.com/150' alt="Product 1 image"><h4>Product 1</h4><h5>R2</h5></li>
            <li><img src='https://via.placeholder.com/150' alt="Product 2 image"><h4>Product 2</h4><h5>R1</h5></li>
            <li><img src='https://via.placeholder.com/150' alt="Product 3 image"><h4>Product 3</h4><h5>R1</h5></li>
        </ul>
        <h5>Shipping</h5><h4>R 1.00</h4>
        <h5 class='total'>Total</h5>
        <h1>R 66</h1>

        <form method="post" action="index.php">
            <input type="submit" class="button-cta" name="paynow" value="REFUND">
        </form>

    </div>
</div>

<?php
if (isset($_POST['paynow'])) {
    try {
        $api = new PayFastApi(
            [
                'merchantId' => '10000100',
                'passPhrase' => '46f0cd694581a',
                'testMode'   => false
            ]
        );

        $refundFetchArray = $api->refunds->fetch('dc0521d3-55fe-269b-fa00-b647310d760f');

        $refundCreateArray = $api->refunds->create('dc0521d3-55fe-269b-fa00-b647310d760f', [
            'amount'   => 50,
            'reason'   => 'Product returned',
            'acc_type' => 'savings'
        ]);
    } catch (Exception $e) {
        echo 'There was an exception: ' . $e->getMessage();
    }
}
?>

</body>
</html>

