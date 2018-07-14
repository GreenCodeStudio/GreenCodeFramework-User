<?php

namespace User\Controllers;

class User extends \Common\PageStandardController {

    function index() {
        $this->addView('User', 'list');

    }



}
