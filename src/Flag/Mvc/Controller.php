<?php namespace Flag\Mvc;

use Flag\Http\Request;
use Flag\Http\Response;

abstract class Controller {

    public function render(string $name, array $data = null, bool $templated = true): void {
        if ($templated) {
            View::renderWithTemplate($name, $data);
        } else {
            View::render($name, $data);
        }
    }

    public function json($data): void {
        Response::json($data);
    }

    public function redirect(string $url): void {
        Response::redirect($url);
    }

    public function isPost(): bool {
        return Request::isPost();
    }
}