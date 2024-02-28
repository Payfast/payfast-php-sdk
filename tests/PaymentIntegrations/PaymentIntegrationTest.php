<?php
declare(strict_types=1);

use Payfast\Exceptions\InvalidRequestException;
use Payfast\PayFastPayment;
use PHPUnit\Framework\TestCase;

final class PaymentIntegrationTest extends TestCase
{

    private $init;

    protected function setUp(): void
    {
        $this->init = [
            'merchantId' => '10000100',
            'merchantKey' => '46f0cd694581a',
            'passPhrase' => '',
            'testMode' => true
        ];
    }

    /**
     * Test instantiation of Payfast payment
     */
    public function testInstantiationOfPayFastPayment()
    {
        $obj = new PayFastPayment($this->init);

        $this->assertInstanceOf('\Payfast\PayFastPayment', $obj);
    }

    /**
     * Make sure exception is thrown if required parameter is missing
     */
    public function testPayFastPaymentException(): void
    {
        $this->expectException(InvalidRequestException::class);

        unset($this->init['merchantId']);

        new PayFastPayment($this->init);
    }


}
