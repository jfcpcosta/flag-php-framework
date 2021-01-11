<?php namespace Flag\Http;

use stdClass;

class Request {

    public static function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isAuthenticated(): bool | stdClass {
        $user = static::session('@flag::user');
        return $user ? $user : false;
    }

    public static function get(string $key, string $defaultValue = null): ?string {
        return isset($_GET[$key]) ? $_GET[$key] : $defaultValue;
    }
    
    public static function post(string $key, string $defaultValue = null): ?string {
        return isset($_POST[$key]) ? $_POST[$key] : $defaultValue;
    }
    
    public static function file(string $key, string $defaultValue = null): ?array {
        return isset($_FILES[$key]) ? $_FILES[$key] : $defaultValue;
    }
    
    public static function session(string $key, $value = null) {
        if (is_null($value)) {
            return Session::get($key);
        }

        Session::set($key, $value);
        return $value;
    }
    
    public static function cookie(string $key, string $value = null, int $time = 3600): ?string {
        if (is_null($value)) {
            return Cookie::get($key);
        }

        Cookie::set($key, $value, $time);
        return $value;
    }
}