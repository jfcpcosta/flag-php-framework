<?php namespace Flag\Http\Errors;

use Exception;

class HttpException extends Exception {

    public function __construct(string $message = 'Internal Server Error', int $code = 500) {
        parent::__construct($message, $code);
    }
}