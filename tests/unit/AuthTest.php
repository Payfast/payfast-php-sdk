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
            'email_address' => 'test@test.com',
            'merchant_key' => '46f0cd694581a',
            'notify_url' => 'http://www.example.com/notify_url',
            'name_first' => 'First',
            'name_last' => 'Last',
            'cancel_url' => 'http://www.example.com/cancel_url',
            'return_url' => 'http://www.example.com/return_url',
            'merchant_id' => '10000100',
        );
        // signature should generated using the correct order
        $signature =  Auth::generateSignature($this->shuffleArrayPreserveKeys($data), $passPhrase = 'test');
        $this->assertTrue("539985d720d80597ed4a1a994871f388" === $signature);
    }
}
?>

