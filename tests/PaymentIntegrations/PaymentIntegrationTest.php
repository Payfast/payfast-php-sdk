<?php
declare(strict_types=1);

use Payfast\Exceptions\InvalidRequestException;
use Payfast\PayfastPayment;
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
    public function testInstantiationOfPayfastPayment()
    {
        $obj = new PayfastPayment($this->init);

        $this->assertInstanceOf('\Payfast\PayfastPayment', $obj);
    }

    /**
     * Make sure exception is thrown if required parameter is missing
     */
    public function testPayfastPaymentException(): void
    {
        $this->expectException(InvalidRequestException::class);

        unset($this->init['merchantId']);

        new PayfastPayment($this->init);
    }


}
