<?php namespace Flag\Mvc;

use Flag\Database\Database;

abstract class Model {

    protected $database;

    public function __construct() {
        $this->database = new Database();
    }
}