<?php


namespace Payfast\PaymentIntegrations;


use Payfast\Auth;
use Payfast\Exceptions\InvalidRequestException;
use Payfast\PayfastBase;
use Payfast\PayfastPayment;

class CustomIntegration extends PayfastBase
{

    /**
     * Payment form data
     * @param array $data
     * @param array $buttonParams
     * @return string
     * @throws InvalidRequestException
     */
    public function createFormFields($data = [], $buttonParams = []): string {
        if(!isset($data['amount'])){
            throw new InvalidRequestException('Required "amount" parameter missing', 400);
        }

        $data['amount'] = number_format( sprintf( '%.2f', $data['amount'] ), 2, '.', '' );

        if(!isset($data['item_name'])){
            throw new InvalidRequestException('Required "item_name" parameter missing', 400);
        }

        $data = ['merchant_id' => PayfastPayment::$merchantId, 'merchant_key' => PayfastPayment::$merchantKey] + $data;

        $signature = Auth::generateSignature($data, PayfastPayment::$passPhrase);
        $data['signature'] = $signature;

        $htmlForm = '<form action="'.PayfastPayment::$baseUrl.'/eng/process" method="post">';
        foreach($data as $name => $value)
        {
            $htmlForm .= '<input name="'.$name.'" type="hidden" value="'.$value.'" />';
        }

        $buttonValue = 'Pay Now';
        if(!empty($buttonParams)) {
            $buttonValue = $buttonParams['value'];
        }
        $additionalOptions = '';
        foreach($buttonParams as $k => $v) {
            $additionalOptions .= $k.'="'.$v.'" ';
        }

        $htmlForm .= '<input type="submit" value="'.$buttonValue.'" '.$additionalOptions.'/>';

        $htmlForm .= '</form>';

        return $htmlForm;
    }

    /**
     * @param null $token
     * @param null $return
     * @param null $linkText
     * @param array $linkParams
     * @return string
     * @throws InvalidRequestException
     */
    public function createCardUpdateLink($token = null,
                                         $return = null,
                                         $linkText = 'Update Card',
                                         $linkParams = []): string
    {
        if($token === null){
            throw new InvalidRequestException('Required "token" parameter missing', 400);
        }
        if(PayfastPayment::$testMode === true) {
            throw new InvalidRequestException('Sorry but this feature is not available in Sandbox mode', 400);
        }

        $additionalOptions = '';
        foreach($linkParams as $k => $v) {
            $additionalOptions .= $k.'="'.$v.'" ';
        }

        $url = PayfastPayment::$baseUrl.'/eng/recurring/update/'.$token;
        if($return) {
            $url .= '?return=' . $return;
        }

        return '<a href="'.$url.'" '.$additionalOptions.'>'.$linkText.'</a>';

    }

}
