<?php


namespace Payfast\PaymentIntegrations;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Payfast\Auth;
use Payfast\Exceptions\InvalidRequestException;
use Payfast\PayfastBase;
use Payfast\PayfastPayment;
use RuntimeException;

class OnsiteIntegration extends PayfastBase
{

    private const PATH = 'onsite/process';

    private function dataToString($dataArray)
    {
        // Create parameter string
        $pfOutput = '';
        foreach ($dataArray as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        // Remove last ampersand
        return substr($pfOutput, 0, -1);
    }

    /**
     * Generate payment identifier
     * @param $data
     * @return mixed|null
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function generatePaymentIdentifier($data)
    {
        if(PayfastPayment::$testMode === true) {
            throw new InvalidRequestException('Sorry but Onsite is not available in Sandbox mode', 400);
        }

        $authDetails = [
            'merchant_id' => PayfastPayment::$merchantId,
            'merchant_key' => PayfastPayment::$merchantKey
        ];
        $data = array_merge($authDetails, $data);

        // Generate signature
        $data["signature"] = Auth::generateSignature($data, PayfastPayment::$passPhrase);

        // Convert the data array to a string
        $pfParamString = $this->dataToString($data);

        try {
            $client = new Client(['base_uri' => PayfastPayment::$baseUrl.'/']);
            $response = $client->request('POST', self::PATH, [
                'headers'  => ['content-type' => 'application/x-www-form-urlencoded'],
                'body' => $pfParamString
            ]);
            $rsp = json_decode($response->getBody(), true);
            if ($rsp['uuid']) {
                return $rsp['uuid'];
            }
            return null;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            throw new InvalidRequestException($response->getBody()->getContents(), 400);
        } catch (GuzzleException $e) {
            throw new InvalidArgumentException($e);
        }

    }

}
