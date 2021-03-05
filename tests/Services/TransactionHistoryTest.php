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
        try {
            self::$api = new PayFastApi(
                [
                    'merchantId' => '10018867',
                    'passPhrase' => '2uU_k5q_vRS_',
                    'testMode' => true
                ]
            );
        } catch (InvalidRequestException $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Test successful range
     */
    public function testRange(): void
    {
        $response = self::$api->transactionHistory->range(['from' => '2020-08-01', 'to' => '2020-08-07']);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful range
     */
    public function testUnsuccessfulRange(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->range(['from' => 'test']);
    }

    /**
     * Test successful daily
     */
    public function testDaily(): void
    {
        $response = self::$api->transactionHistory->daily(['date' => '2020-08-07']);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful daily
     */
    public function testUnsuccessfulDaily(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->daily(['date' => 'test']);
    }

    /**
     * Test successful weekly
     */
    public function testWeekly(): void
    {
        $response = self::$api->transactionHistory->weekly(['date' => '2020-08-07']);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful weekly
     */
    public function testUnsuccessfulWeekly(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->weekly(['date' => 'test']);
    }

    /**
     * Test successful monthly
     */
    public function testMonthly(): void
    {
        $response = self::$api->transactionHistory->monthly(['date' => '2020-08']);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful monthly
     */
    public function testUnsuccessfulMonthly(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->monthly(['date' => '2020-08-01']);
    }

}
