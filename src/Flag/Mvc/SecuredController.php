<?php namespace Flag\Mvc;

use Flag\Http\FlashBag;
use Flag\Http\Request;
use Flag\Http\Session;
use stdClass;

abstract class SecuredController extends Controller {

    protected $user;

    public function __construct()
    {
        $this->user = Request::isAuthenticated();

        if (!$this->user) {
            FlashBag::add('Forbidden', 'danger');
            $this->redirect('/');
        }
    }

    public static function setUser(stdClass $user): void {
        Session::set('@flag::user', $user);
    }

    public static function logout(): void {
        Session::remove('@flag::user');
    }
}