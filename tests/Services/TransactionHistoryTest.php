<?php
declare(strict_types=1);

use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastApi;
use PHPUnit\Framework\TestCase;

final class TransactionHistoryTest extends TestCase
{

    private static $api;

    public const OFFSET = 0;
    public const LIMIT = 5;

    public static function setUpBeforeClass(): void
    {
        try {
            self::$api = new PayFastApi(
                [
                    'merchantId' => '10026755',
                    'passPhrase' => 'test_sandbox',
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
        $response = self::$api->transactionHistory->range(['from' => '2020-08-01', 'to' => '2020-08-07', 'offset' => self::OFFSET, 'limit' => self::LIMIT]);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful range
     */
    public function testUnsuccessfulRange(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->range(['from' => 'test', 'offset' => 'A', 'limit' => '1000']);
    }

    /**
     * Test successful daily
     */
    public function testDaily(): void
    {
        $response = self::$api->transactionHistory->daily(['date' => '2020-08-07', 'offset' => self::OFFSET, 'limit' => self::LIMIT]);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful daily
     */
    public function testUnsuccessfulDaily(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->daily(['date' => 'test', 'offset' => 'A', 'limit' => '1000']);
    }

    /**
     * Test successful weekly
     */
    public function testWeekly(): void
    {
        $response = self::$api->transactionHistory->weekly(['date' => '2020-08-07', 'offset' => self::OFFSET, 'limit' => self::LIMIT]);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful weekly
     */
    public function testUnsuccessfulWeekly(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->weekly(['date' => 'test', 'offset' => 'A', 'limit' => '1000']);
    }

    /**
     * Test successful monthly
     */
    public function testMonthly(): void
    {
        $response = self::$api->transactionHistory->monthly(['date' => '2020-08', 'offset' => self::OFFSET, 'limit' => self::LIMIT]);

        self::assertIsString($response);
    }

    /**
     * Test unsuccessful monthly
     */
    public function testUnsuccessfulMonthly(): void
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->transactionHistory->monthly(['date' => '2020-08-01', 'offset' => 'A', 'limit' => '1000']);
    }

}
