<?php namespace Flag\Http\Errors;

class NotFoundException extends HttpException {

    public function __construct(string $message = 'Not found') {
        parent::__construct($message, 404);
    }
}