<?php
declare(strict_types=1);

use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastApi;
use PHPUnit\Framework\TestCase;

final class TransactionHistoryTest extends TestCase
{

    private static $api;

    public static function setUpBeforeClass(): void
    {
        self::$api = new PayFastApi([
            'merchantId' => '10018867',
            'passPhrase' => '2uU_k5q_vRS_',
            'testMode' => true
        ]);
    }

    /**
     * Test successful range
     */
    public function testRange()
    {
        $response = self::$api->transactionHistory->range(['from' => '2020-08-01', 'to' => '2020-08-07']);

        $this->assertIsString($response);
    }

    /**
     * Test unsuccessful range
     */
    public function testUnsuccessfulRange()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->range(['from' => 'test']);
    }

    /**
     * Test successful daily
     */
    public function testDaily()
    {
        $response = self::$api->transactionHistory->daily(['date' => '2020-08-07']);

        $this->assertIsString($response);
    }

    /**
     * Test unsuccessful daily
     */
    public function testUnsuccessfulDaily()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->daily(['date' => 'test']);
    }

    /**
     * Test successful weekly
     */
    public function testWeekly()
    {
        $response = self::$api->transactionHistory->weekly(['date' => '2020-08-07']);

        $this->assertIsString($response);
    }

    /**
     * Test unsuccessful weekly
     */
    public function testUnsuccessfulWeekly()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->weekly(['date' => 'test']);
    }

    /**
     * Test successful monthly
     */
    public function testMonthly()
    {
        $response = self::$api->transactionHistory->monthly(['date' => '2020-08']);

        $this->assertIsString($response);
    }

    /**
     * Test unsuccessful monthly
     */
    public function testUnsuccessfulMonthly()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->monthly(['date' => '2020-08-01']);
    }

}
