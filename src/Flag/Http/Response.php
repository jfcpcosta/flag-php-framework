<?php namespace Flag\Http;

class Response {

    public static function redirect(string $url): void {
        header("Location: $url");
        exit(301);
    }

    public static function json($data): void {
        echo json_encode($data);
    }

    public static function status(int $code, string $message): void {
        header("HTTP/1.1 $code $message");
    }

    public static function badRequest(): void {
        static::status(400, 'Bad Request');    
    }
    
    public static function notFound(): void {
        static::status(404, 'Not Found');    
    }
    
    public static function unauthorized(): void {
        static::status(401, 'Unauthorized');    
    }
    
    public static function forbidden(): void {
        static::status(403, 'Forbidden');    
    }
    
    public static function internalServerError(): void {
        static::status(500, 'Internal Server Error');    
    }
}