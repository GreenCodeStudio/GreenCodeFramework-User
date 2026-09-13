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
        return $user->getById($id);
    }
    function addAdmin(string $name, string $surname, string $mail, string $password)
    {
        $id=$this->add($name,$surname,$mail,$password);
        $this->addAllPermissions($id);
        return $id;
    }

    function get()
    {
        $user = new \User\User();
        return $user->getAll();
    }

    function addPermssion(int $idUser, string $group, string $name)
    {

        $user = new \User\User();
        $user->addPermission($idUser, $group, $name);
    }

    function addAllPermissions(int $idUser)
    {

        $user = new \User\User();
        $user->addAllPermissions($idUser);
    }
}
