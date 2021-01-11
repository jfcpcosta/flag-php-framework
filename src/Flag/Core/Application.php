<?php namespace Flag\Core;

use Flag\Http\Errors\HttpException;
use Flag\Http\Errors\InternalServerErrorException;
use Flag\Http\Errors\NotFoundException;
use Flag\Router\Model\Route;
use Flag\Router\Router;
use ReflectionClass;
use ReflectionException;

class Application {

    private $defaultRoute = '/';
    private $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function start(): void {
        $uri = $this->getUri();

        try {
            $route = $this->router->get($uri);
            $this->invoke($route);
        } catch (HttpException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();

            header("HTTP/1.1 $code $message");
            die($code . " " . $message);
        }
    }

    public function invoke(Route $route): void {
        $controller = $route->getController();
        $action = $route->getAction();

        try {
            $reflector = new ReflectionClass($controller);
    
            if ($reflector->isInstantiable()) {
                $instance = $reflector->newInstance();
                $method = $reflector->getMethod($action);
    
                if ($route->hasData()) {
                    $method->invokeArgs($instance, $route->getData());
                } else {
                    $method->invoke($instance);
                }
    
                return;
            }
        } catch (ReflectionException $e) {
            throw new InternalServerErrorException($e->getMessage());
        }
    }

    public function getUri(): string {
        return isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $this->defaultRoute;
    }
}