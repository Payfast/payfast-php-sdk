<?php
declare(strict_types=1);

use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastApi;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{

    private $init;

    protected function setUp(): void
    {
        $this->init = [
            'merchantId' => '10018867',
            'passPhrase' => '2uU_k5q_vRS_',
            'testMode' => true
        ];
    }

    /**
     * Test instantiation of PayFast API Service
     */
    public function testInstantiationOfPayFastService()
    {
        $obj = new PayFastApi($this->init);
        $this->assertInstanceOf('\PayFast\PayFastApi', $obj);
    }

    /**
     * Make sure exception is thrown if required parameter is missing
     */
    public function testPayFastApiException(): void
    {
        $this->expectException(InvalidRequestException::class);

        unset($this->init['merchantId']);

        new PayFastApi($this->init);
    }


}
