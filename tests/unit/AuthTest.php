<?php
use PHPUnit\Framework\TestCase;
use PayFast\Auth;

class AuthTest extends TestCase
{
    private function shuffleArrayPreserveKeys($array)
    {
        $keys = array_keys($array);
        shuffle($keys);
        $new = [];
        foreach ($keys as $key)
        {
            $new[$key] = $array[$key];
        }
        return $new;
    }
    public function testGenerateSignatureOrdering()
    {
        $data = array(
            'merchant_id'          => 10028084,
            'merchant_key'         => '4hjoenwbwnuso',
            'subscription_type'    => 1,
            'm_payment_id'         => '5',
            'amount'               => '5.00',
            'recurring_amount'     => '5',
            'billing_date'         => '2023-01-01',
            'frequency'            => 3,
            'cycles'               => 0,
            'custom_str1'          => rtrim(base64_encode('Some Test String'), '='),
            'custom_int1'          => 1,
            'custom_int2'          => 1,
            'custom_str2'          => rtrim(base64_encode('Another Test String'), '='),
            'item_name'            => 'Test',
            'name_last'            => 'Test',
            'name_first'           => 'Test',
            'email_address'        => 'test@test.com',
            'confirmation_address' => 'test@test.test',
            'email_confirmation'   => 1,
            'return_url'           => 'https://test.com/billing/success',
            'cancel_url'           => 'https://test.com/billing/cancel',
            'notify_url'           => 'https://test.com/payfast/webhook'
        );

        // signature should generated using the correct order
        $signature =  Auth::generateSignature($this->shuffleArrayPreserveKeys($data), $passPhrase = 'payfastsandbox');
        $this->assertTrue("3441682c5d8a65486f5b7cc8ce41d146" === $signature);
    }
}
?>

