<?php namespace Flag\Mvc;

use Flag\Http\Errors\NotFoundException;
use Flag\Http\Request;
use Flag\Persistence\FileSystem;

class View {
 
    public static function render(string $name, array $data = null): void {
        if (!is_null($data)) {
            extract($data);
        }

        $viewPath = "../views/$name.phtml";

        if (FileSystem::exists($viewPath)) {
            if (!isset($user)) {
                $user = Request::isAuthenticated();
            }

            $helpers = FileSystem::folderContent('../views/helpers', '*.helper.php');
            
            foreach ($helpers as $helper) {
                require_once $helper;
            }

            include $viewPath;
        } else {
            throw new NotFoundException("View not found");
        }
    }

    public static function renderWithTemplate(string $name, array $data = null): void {
        static::render('templates/header', $data);
        static::render($name, $data);
        static::render('templates/footer', $data);
    }
}