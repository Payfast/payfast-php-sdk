<?php


namespace PayFast;


class Auth
{

    /**
     * Generate signature for API
     * @param array $pfData (all of the header and body values to be sent to the API)
     * @param null|string $passPhrase
     * @return string
     */
    public static function generateApiSignature(array $pfData, string $passPhrase = null) {

        // Construct variables
        foreach ($pfData as $key => $val) {
            $data[$key] = stripslashes($val);
        }

        if ($passPhrase !== null) {
            $pfData['passphrase'] = $passPhrase;
        }

        // Sort the array by key, alphabetically
        ksort($pfData);

        // Normalise the array into a parameter string
        $pfParamString = '';
        foreach ($pfData as $key => $val) {
            if ($key !== 'signature') {
                $pfParamString .= $key . '=' . urlencode($val) . '&';
            }
        }

        // Remove the last '&amp;' from the parameter string
        $pfParamString = substr($pfParamString, 0, -1);
        return md5($pfParamString);
    }

    /**
     * Generate signature for payment integrations
     * @param $data
     * @param null $passPhrase
     * @return string
     */
    public static function generateSignature($data, $passPhrase = null) {
        // Create parameter string
        $pfOutput = '';
        foreach( $data as $key => $val ) {
            if(!empty($val)) {
                $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
            }
        }
        // Remove last ampersand
        $getString = substr( $pfOutput, 0, -1 );
        if( $passPhrase !== null ) {
            $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
        }
        return md5( $getString );
    }

}
