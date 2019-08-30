<?php

namespace User\Console;

use Core\AbstractController;
use stdClass;

class User extends AbstractController
{

    function add(string $name, string $surname, string $mail, string $password)
    {
        $user = new \User\User();
        $data = new stdClass();
        $data->name = $name;
        $data->surname = $surname;
        $data->mail = $mail;
        $data->password = $data->password2 = $password;
        $data->permission = [];
        $id = $user->insert($data);
    }
}
