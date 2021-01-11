<?php namespace Flag\Router;

use Flag\Http\Errors\NotFoundException;
use Flag\Persistence\FileSystem;
use Flag\Router\Model\Route;

class Router {
    
    private $routes = [];

    public function __construct(string $routesFilePath = '../configs/routes.config.php') {
        if (FileSystem::exists($routesFilePath)) {
            $this->routes = require $routesFilePath;
        }
    }

    public function add(string $endpoint, Route $route) {
        if (!isset($this->routes[$endpoint])) {
            $this->routes[$endpoint] = sprintf("%s::%s", $route->getController(), $route->getAction());
        }
    }

    public function get(string $uri): Route {
        if (strpos($uri, ':') === false && isset($this->routes[$uri])) {
            return new Route($this->routes[$uri]);
        } else {
            $segments = explode('/', $uri);
            $segmentsCount = count($segments);
            $routeData = [];

            foreach ($this->routes as $key => $route) {
                $routeSegments = explode('/', $key);

                if ($segmentsCount === count($routeSegments)) {
                    $match = true;

                    for ($i = 0; $i < $segmentsCount; $i++) {
                        if (isset($routeSegments[$i][0]) && $routeSegments[$i][0] === ':') {
                            $routeData[substr($routeSegments[$i], 1)] = $segments[$i];
                            continue;
                        }

                        if ($segments[$i] !== $routeSegments[$i]) {
                            $match = false;
                            break;
                        }
                    }

                    if ($match) {
                        return new Route($route, $routeData);
                    }
                }
            }
        }

        throw new NotFoundException();
    }
}