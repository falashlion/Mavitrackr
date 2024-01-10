<?php
namespace App\Exceptions;
use Exception;
class NonWeightException extends Exception{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $message = "KPI does not have a weight Can not assign score";
        parent::__construct($message, $code, $previous);
    }

}
