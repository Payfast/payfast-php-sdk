<?php
declare(strict_types=1);

use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastApi;
use PHPUnit\Framework\TestCase;

final class SubscriptionsTest extends TestCase
{

    private static $api;
    public static $token;
    public static $adhocToken;

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
        self::$token = '2afa4575-5628-051a-d0ed-4e071b56a7b0';
        self::$adhocToken = '290ac9a6-25f1-cce4-5801-67a644068818';
    }

    /**
     * Test successful fetch
     * @return void
     */
    public function testFetch()
    {
        $response = self::$api->subscriptions->fetch(self::$token);

        self::assertEquals("success", $response['status']);

        return $response['data']['response']['status_text'];
    }

    /**
     * Test unsuccessful fetch
     */
    public function testUnsuccessfulFetch()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->fetch('test');
    }

    /**
     * Test successful pause
     * @return void
     */
    public function testPause()
    {
        $response = self::$api->subscriptions->pause(self::$token, ['cycles' => 1]);

        self::assertContains($response['status'], ["success", "failed"]);
    }

    /**
     * Test unsuccessful pause
     */
    public function testUnsuccessfulPause()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->pause('test', ['cycles' => 1]);
    }

    /**
     * Test successful unpause
     */
    public function testUnpause()
    {
        $response = self::$api->subscriptions->unpause(self::$token);

        $this->assertContains($response['status'], ["success", "failed"]);
    }

    /**
     * Test unsuccessful unpause
     */
    public function testUnsuccessfulUnpause()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->unpause('test');
    }

    /**
     * Test successful update
     */
    public function testUpdate()
    {
        $response = self::$api->subscriptions->update(self::$token, ['frequency' => 3]);

        $this->assertEquals("success", $response['status']);
    }

    /**
     * Test unsuccessful update
     */
    public function testUnsuccessfulUpdate()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->update('test');
    }

    /**
     * Test successful tokenization payment
     */
    public function testAdhoc()
    {
        $response = self::$api->subscriptions->adhoc(self::$adhocToken, ['amount' => 500, 'item_name' => 'Test adhoc']);

        $this->assertContains($response['status'], ["success", "failed"]);
    }

    /**
     * Test unsuccessful tokenization payment
     */
    public function testUnsuccessfulAdhoc()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->adhoc('test');
    }

    /**
     * Test successful cancel
     */
    public function testCancel()
    {
        $response = self::$api->subscriptions->cancel(self::$token, ['cycles' => 1]);

        $this->assertContains($response['status'], ["success", "failed"]);
    }

    /**
     * Test unsuccessful cancel
     */
    public function testUnsuccessfulCancel()
    {
        $this->expectException(InvalidRequestException::class);

        self::$api->subscriptions->cancel('test');
    }

}
