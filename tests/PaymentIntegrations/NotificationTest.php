<?php

declare(strict_types=1);

namespace PaymentIntegrations;

use PayFast\PayFastPayment;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class NotificationTest extends TestCase
{
    private static PayFastPayment $payFastPayment;
    private static string $passPhrase;
    private array $data;

    /**
     * @throws \PayFast\Exceptions\InvalidRequestException
     */
    public static function setUpBeforeClass(): void
    {
        self::$payFastPayment = new PayFastPayment([
                                                       'merchantId'  => '10000100',
                                                       'merchantKey' => '46f0cd694581a',
                                                       'passPhrase'  => '',
                                                       'testMode'    => true
                                                   ]);

        self::$passPhrase = '';
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws ReflectionException|\ReflectionException
     */
    public function invokeMethod(object $object, string $methodName, array $parameters = array()): mixed
    {
        $reflection = new ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Test successful notification
     * @throws \ReflectionException
     */
    public function testSignatureCheck()
    {
        $pfData        = $this->invokeMethod(
            self::$payFastPayment->notification,
            'cleanNotificationData',
            [$this->data]
        );
        $pfParamString = $this->invokeMethod(
            self::$payFastPayment->notification,
            'dataToString',
            [$pfData]
        );
        $test          = $this->invokeMethod(
            self::$payFastPayment->notification,
            'pfValidSignature',
            [$pfData, $pfParamString, self::$passPhrase]
        );

        $this->assertTrue($test);
    }

    /**
     * Test unsuccessful notification
     * @throws \ReflectionException
     */
    public function testInvalidSignatureCheck()
    {
        $this->data['amount_gross'] = '11.00';

        $pfData        = $this->invokeMethod(
            self::$payFastPayment->notification,
            'cleanNotificationData',
            [$this->data]
        );
        $pfParamString = $this->invokeMethod(
            self::$payFastPayment->notification,
            'dataToString',
            [$pfData]
        );
        $test          = $this->invokeMethod(
            self::$payFastPayment->notification,
            'pfValidSignature',
            [$pfData, $pfParamString]
        );

        $this->assertFalse($test);
    }

    /**
     * Test correct payment data
     * @throws \ReflectionException
     */
    public function testValidPaymentDataCheck()
    {
        $pfData = $this->invokeMethod(
            self::$payFastPayment->notification,
            'cleanNotificationData',
            [$this->data]
        );
        $test   = $this->invokeMethod(
            self::$payFastPayment->notification,
            'pfValidData',
            [$pfData, ['amount_gross' => '15.00']]
        );

        $this->assertTrue($test);
    }

    /**
     * Test incorrect payment data
     * @throws \ReflectionException
     */
    public function testInvalidPaymentDataCheck()
    {
        $this->data['amount_gross'] = '11.00';

        $pfData = $this->invokeMethod(
            self::$payFastPayment->notification,
            'cleanNotificationData',
            [$this->data]
        );
        $test   = $this->invokeMethod(
            self::$payFastPayment->notification,
            'pfValidData',
            [$pfData, ['amount_gross' => '10.00']]
        );

        $this->assertFalse($test);
    }

    /**
     * Test server confirmation
     * @throws \ReflectionException
     */
    public function testServerConfirmationCheck()
    {
        $pfData = $this->invokeMethod(
            self::$payFastPayment->notification,
            'cleanNotificationData',
            [$this->data]
        );

        $pfParamString = $this->invokeMethod(
            self::$payFastPayment->notification,
            'dataToString',
            [$pfData]
        );

        if (empty(self::$passPhrase)) {
            $sig = md5($pfParamString);
        } else {
            $sig = md5("$pfParamString&passphrase=" . self::$passPhrase);
        }

        parse_str("$pfParamString&signature=$sig", $result);

        $test = $this->invokeMethod(
            self::$payFastPayment->notification,
            'pfValidServerConfirmation',
            ["$pfParamString&signature=$sig"]
        );

        $this->assertTrue($test);
    }

    /**
     * Test invalid server confirmation
     * @throws \ReflectionException
     */
    public function testInvalidServerConfirmationCheck()
    {
        $test = $this->invokeMethod(self::$payFastPayment->notification, 'pfValidServerConfirmation', ['testing']);

        $this->assertFalse($test);
    }

    /**
     * Make sure an invalid notification fails
     */
    public function testUnsuccessfulNotification(): void
    {
        $data = ['some bad data'];

        $notification = self::$payFastPayment->notification->isValidNotification($data, ['amount_gross' => '10.00']);

        $this->assertFalse($notification);
    }

    protected function setUp(): void
    {
        $this->data = [
            'm_payment_id'     => '1234',
            'pf_payment_id'    => '1221576',
            'payment_status'   => 'COMPLETE',
            'item_name'        => 'Order#123',
            'item_description' => '',
            'amount_gross'     => '10.00',
            'amount_fee'       => '-0.23',
            'amount_net'       => '9.77',
            'custom_str1'      => '',
            'custom_str2'      => '',
            'custom_str3'      => '',
            'custom_str4'      => '',
            'custom_str5'      => '',
            'custom_int1'      => '',
            'custom_int2'      => '',
            'custom_int3'      => '',
            'custom_int4'      => '',
            'custom_int5'      => '',
            'name_first'       => 'First',
            'name_last'        => 'Last',
            'email_address'    => 'test@test.com',
            'merchant_id'      => '10000100',
            'signature'        => 'ac4c3e993d31b5b9d525dc0087051437'
        ];

        // phpcs:disable
        $this->data = json_decode(
            '{"m_payment_id":"000000020","pf_payment_id":"1579137","payment_status":"COMPLETE","item_name":"Order #000000020","item_description":"","amount_gross":"15.00","amount_fee":"-2.30","amount_net":"12.70","custom_str1":"","custom_str2":"","custom_str3":"","custom_str4":"","custom_str5":"","custom_int1":"","custom_int2":"","custom_int3":"","custom_int4":"","custom_int5":"","name_first":"Tom","name_last":"Tom","email_address":"lindley+user1@appinlet.com","merchant_id":"10027938","signature":"4078bca2c8987e0e0c4e7230f2f46323"}',
            true
        );
        // phpcs:enable
    }
}
