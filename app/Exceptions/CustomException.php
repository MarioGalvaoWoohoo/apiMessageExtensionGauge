<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $data;

    public function __construct($data = [], $code = 0, Exception $previous = null) {
        $this->data = $data;
        parent::__construct('', $code, $previous);
    }

    public function getData() {
        return $this->data['error'];
    }
}
