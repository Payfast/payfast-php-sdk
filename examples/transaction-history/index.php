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
        <h2>Transaction History Demo</h2>


<?php
if(isset($_POST['paynow'])) {
    try {
        $api = new PayFastApi(
            [
                'merchantId' => '10000100',
                'passPhrase' => 'jt7NOE43FZPn',
                'testMode' => true
            ]
        );
        $fromDate = '2020-08-01';
        $toDate = '2020-08-07';

        $rangeArray = $api->transactionHistory->range(['from' => $fromDate, 'to' => $toDate,
            'offset' => 0, 'limit' => 1000]);

        $dailyArray = $api->transactionHistory->daily(['date' => $toDate, 'offset' => 0, 'limit' => 1000]);

        $weeklyArray = $api->transactionHistory->weekly(['date' => $toDate, 'offset' => 0, 'limit' => 1000]);

        $monthlyArray = $api->transactionHistory->monthly(['date' => '2020-08', 'offset' => 0, 'limit' => 1000]);
            echo '<div id="view">' . print_r($rangeArray, true) . '</div>';

    } catch(Exception $e) {
        echo 'There was an exception: '.$e->getMessage();
    }
}
?>

        <form method="post" action="index.php">
            <input type="submit" class="button-cta" name="paynow" value="View Transactions">
        </form>

    </div>
</div>

</body>
</html>

