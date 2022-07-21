<?php


namespace PayFast\Services;


use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastBase;
use PayFast\Request;
use PayFast\Validate;
use RuntimeException;

class TransactionHistory extends PayFastBase
{

    private const PATH = 'transactions/history';


    /**
     * Transaction history
     * $payfast->transactionHistory->range(['from' => '2020-08-01', 'to' => '2020-08-07', 'offset' => 0, 'limit' => 1000]);
     * @param $data
     * @return string
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function range($data = []) : string {
        $queryParam = [];
        if(!isset($data['from'])){
            $data['from'] = date("Y-m-d");
        }
        try {
            $queryParam['from'] = Validate::validateDate($data['from'], 'Y-m-d', 'from');
            if(isset($data['to'])) {
                $queryParam['to'] = Validate::validateDate($data['to'], 'Y-m-d', 'to');
                if($data['to'] < $data['from']) {
                    $queryParam['to'] = $data['from'];
                    $queryParam['from'] = $data['to'];
                }
            }
            if(isset($data['offset'])) {
                if (!is_numeric($data['offset'])) {
                    throw new InvalidRequestException('Variable "offset" must be an integer.', 400);
                }
                $queryParam['offset'] = $data['offset'];
            }
            if(isset($data['limit'])) {
                if (!is_numeric($data['limit'])) {
                    throw new InvalidRequestException('Variable "limit" must be an integer.', 400);
                }
                $queryParam['limit'] = $data['limit'];
            }
            $response = Request::sendApiRequest('GET', self::PATH, $queryParam);
            return $response->getContents();
        }catch (ClientException $e) {
            $response = $e->getResponse();
            throw new InvalidRequestException($response->getBody()->getContents(), 400);
        } catch (GuzzleException $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * Daily transaction history
     * $payfast->transactionHistory->daily(['date' => '2020-08-07']);
     * @param $data
     * @return string
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function daily($data) : string {
        if(!isset($data['date'])){
            throw new InvalidRequestException('Required "date" parameter missing', 400);
        }
        $queryParam['date'] = $data['date'];
        if(isset($data['offset'])) {
            if (!is_numeric($data['offset'])) {
                throw new InvalidRequestException('Variable "offset" must be an integer.', 400);
            }
            $queryParam['offset'] = $data['offset'];
        }
        if(isset($data['limit'])) {
            if (!is_numeric($data['limit'])) {
                throw new InvalidRequestException('Variable "limit" must be an integer.', 400);
            }
            $queryParam['limit'] = $data['limit'];
        }
        try {
            Validate::validateDate($data['date'], 'Y-m-d');
            $response = Request::sendApiRequest('GET', self::PATH . '/daily', $queryParam);
            return $response->getContents();
        }catch (ClientException $e) {
            $response = $e->getResponse();
            throw new InvalidRequestException($response->getBody()->getContents(), 400);
        } catch (GuzzleException $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * Weekly transaction history
     * $payfast->transactionHistory->weekly(['date' => '2020-08-07']);
     * @param $data
     * @return string
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function weekly($data) : string {
        if(!isset($data['date'])){
            throw new InvalidRequestException('Required "date" parameter missing', 400);
        }
        $queryParam['date'] = $data['date'];
        if(isset($data['offset'])) {
            if (!is_numeric($data['offset'])) {
                throw new InvalidRequestException('Variable "offset" must be an integer.', 400);
            }
            $queryParam['offset'] = $data['offset'];
        }
        if(isset($data['limit'])) {
            if (!is_numeric($data['limit'])) {
                throw new InvalidRequestException('Variable "limit" must be an integer.', 400);
            }
            $queryParam['limit'] = $data['limit'];
        }
        try {
            Validate::validateDate($data['date'], 'Y-m-d');
            $response = Request::sendApiRequest('GET', self::PATH . '/weekly', $queryParam);
            return $response->getContents();
        }catch (ClientException $e) {
            $response = $e->getResponse();
            throw new InvalidRequestException($response->getBody()->getContents(), 400);
        } catch (GuzzleException $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * Monthly transaction history
     * $payfast->transactionHistory->monthly(['date' => '2020-08']);
     * @param $data
     * @return string
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function monthly($data) : string {
        if(!isset($data['date'])){
            throw new InvalidRequestException('Required "date" parameter missing', 400);
        }
        $queryParam['date'] = $data['date'];
        if(isset($data['offset'])) {
            if (!is_numeric($data['offset'])) {
                throw new InvalidRequestException('Variable "offset" must be an integer.', 400);
            }
            $queryParam['offset'] = $data['offset'];
        }
        if(isset($data['limit'])) {
            if (!is_numeric($data['limit'])) {
                throw new InvalidRequestException('Variable "limit" must be an integer.', 400);
            }
            $queryParam['limit'] = $data['limit'];
        }
        try {
            Validate::validateDate($data['date'], 'Y-m');
            $response = Request::sendApiRequest('GET', self::PATH . '/monthly', $queryParam);
            return $response->getContents();
        }catch (ClientException $e) {
            $response = $e->getResponse();
            throw new InvalidRequestException($response->getBody()->getContents(), 400);
        } catch (GuzzleException $e) {
            throw new RuntimeException($e);
        }
    }

}
