<?php namespace Flag\Router\Model;

class Route {

    private $endpoint;
    private $controller;
    private $action;
    private $data;

    public function __construct(string $route, array $data = []) {
        $this->endpoint = $route;
        $this->data = $data;
        $this->parse();
    }

    private function parse(): void {
        $parts = explode('::', $this->endpoint);
        $this->controller = $parts[0];
        $this->action = $parts[1];
    }

    public function getController(): string {
        return $this->controller;
    }
    
    public function getAction(): string {
        return $this->action;
    }

    public function hasData(): bool {
        return count($this->data) > 0;
    }

    public function getData(): array {
        return $this->data;
    }
}