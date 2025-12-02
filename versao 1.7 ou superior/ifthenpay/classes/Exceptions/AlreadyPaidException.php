<?php

namespace PrestaShop\Module\Ifthenpay\Exceptions;

use Exception;

class AlreadyPaidException extends Exception
{

    protected $errorCode;



    public function __construct($message, $errorCode = 0, $previous = null)
    {
        $this->errorCode = $errorCode;

        parent::__construct($message, 0, $previous);
    }
}
