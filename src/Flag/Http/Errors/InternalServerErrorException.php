<?php namespace Flag\Http\Errors;

class InternalServerErrorException extends HttpException {

    public function __construct(string $message = 'InternalServerError') {
        parent::__construct($message, 500);
    }
}