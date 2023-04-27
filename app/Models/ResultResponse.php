<?php

namespace App\Models;

class ResultResponse
{
    CONST CODE_SUCCESS = 200;
    CONST CODE_SUCCESS_CREATED = 201;
    CONST CODE_SUCCESS_ACCEPTED = 202;
    CONST CODE_ERROR = 300;
    CONST CODE_NOT_FOUND = 404;

    CONST TXT_SUCCESS = 'Success';
    CONST TXT_ERROR = 'Error';
    CONST TXT_NOT_FOUND = 'Element not found';

    public $statusCode, $message, $data;

    function __construct($statusCode = self::CODE_ERROR, $message = self::TXT_ERROR, $data = []){
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    public function setResponse($statusCode = self::CODE_ERROR, $message = self::TXT_ERROR, $data = []){
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    public function getStatusCode(){
        return $this->statusCode;
    }
}
