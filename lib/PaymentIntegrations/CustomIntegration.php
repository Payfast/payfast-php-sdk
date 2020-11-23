<?php


namespace PayFast\PaymentIntegrations;


use PayFast\Auth;
use PayFast\Exceptions\InvalidRequestException;
use PayFast\PayFastBase;
use PayFast\PayFastPayment;

class CustomIntegration extends PayFastBase
{

    /**
     * Payment form data
     * @param array $data
     * @param array $buttonParams
     * @return string
     * @throws InvalidRequestException
     */
    public function createFormFields($data = [], $buttonParams = []) {
        if(!isset($data['amount'])){
            throw new InvalidRequestException('Required "amount" parameter missing', 400);
        } else {
            $data['amount'] = number_format( sprintf( '%.2f', $data['amount'] ), 2, '.', '' );
        }
        if(!isset($data['item_name'])){
            throw new InvalidRequestException('Required "item_name" parameter missing', 400);
        }

        $data = ['merchant_id' => PayFastPayment::$merchantId, 'merchant_key' => PayFastPayment::$merchantKey] + $data;

        $signature = Auth::generateSignature($data);
        $data['signature'] = $signature;

        $htmlForm = '<form action="'.PayFastPayment::$baseUrl.'/eng/process" method="post">';
        foreach($data as $name=> $value)
        {
            $htmlForm .= '<input name="'.$name.'" type="hidden" value="'.$value.'" />';
        }
        if(!empty($buttonParams)) {
            $value = (isset($buttonParams['value'])) ? $buttonParams['value'] : 'Pay Now';
            unset($buttonParams['value']);
        }
        $additionalOptions = '';
        foreach($buttonParams as $k => $v) {
            $additionalOptions .= $k.'="'.$v.'" ';
        }

        $htmlForm .= '<input type="submit" value="'.$value.'" '.$additionalOptions.'/>';

        $htmlForm .= '</form>';

        return $htmlForm;
    }

}
