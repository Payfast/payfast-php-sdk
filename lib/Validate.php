<?php


namespace PayFast;


use Exception;
use PayFast\Exceptions\InvalidRequestException;

class Validate
{
    static $errors = true;

    /**
     * Validate Date
     * validateDate('14:50', 'H:i')
     * @param $date
     * @param string $format
     * @param string $paramName
     * @return bool
     * @throws InvalidRequestException
     */
    static function validateDate($date, $format = 'Y-m-d H:i:s', $paramName = "date")
    {
        $createDate = date_create($date);
        if($createDate == '' || date_format($createDate, $format) !== $date){
            throw new InvalidRequestException('Invalid date format for "'.$paramName.'"', 400);
        }
        return $date;
    }

    /**
     * @param $value
     * @param $key
     * @return int|string
     * @throws InvalidRequestException
     */
    static function validateInt($value, $key)
    {
        if(!is_numeric($value)) {
            throw new InvalidRequestException('Invalid format for "'.$key.'"', 400);
        }
        return $value;
    }

    /**
     * Remove items from an array if they are not in the allowed list
     * @param $array
     * @param $validation
     * @throws InvalidRequestException
     */
    static function validateOptions($array, $validation) {
        try {
            foreach($array as $attribute => $value) {
                if(isset($validation[$attribute])) {
                    switch ($validation[$attribute]) {
                        case 'int':
                            Validate::validateInt($value, $attribute);
                            break;
                        case 'date':
                            Validate::validateDate($value, "Y-m-d" ,$attribute);
                            break;
                    }
                }
            }
        } catch (InvalidRequestException $e) {
            throw new InvalidRequestException($e->getMessage(), 400);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
