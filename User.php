<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:50
 */

namespace User;


use User\Repository\UserRepository;

class User extends \Core\BussinesLogic
{
    public function __construct()
    {
        $this->defaultDB = new UserRepository();
    }

    public function getDataTable($options)
    {
        return $this->defaultDB->getDataTable($options);
    }

    public function getPermissions(int $userId)
    {
        return $this->defaultDB->getPermissions($userId);
    }

    public function update(int $id, $data)
    {
        $filtered = $this->filterData($data);
        $this->defaultDB->update($id, $filtered);
        $this->savePermissions($data->permission, $id);
        if (!empty($data->password) && $data->password === $data->password2) {
            $this->changePassword($id, $data->password);
        }
        \Core\WebSocket\Sender::sendToUsers(["User", "User", "Update", $id]);
    }

    protected function filterData($data)
    {
        $ret = [];
        $ret['name'] = $data->name;
        $ret['surname'] = $data->surname;
        $ret['mail'] = $data->mail;
        return $ret;
    }

    private function savePermissions($permission, int $idUser)
    {
        $prepared = [];
        foreach ($permission as $groupName => $group) {
            foreach ($group as $name => $value) {
                $prepared[] = ['group' => $groupName, 'name' => $name, 'id_user' => $idUser];
            }
        }
        $this->defaultDB->savePermissions($prepared, $idUser);
    }

    public function changePassword(int $id, $password)
    {
        $salt = \Authorization\Authorization::generateSalt();
        $passwordhash = \Authorization\Authorization::hashPassword($password, $salt);
        $this->defaultDB->update($id, ['password' => $passwordhash, 'salt' => $salt]);
    }

    public function insert($data)
    {
        $filtered = $this->filterData($data);
        $id = $this->defaultDB->insert($filtered);
        $this->savePermissions($data->permission, $id);
        if (!empty($data->password) && $data->password === $data->password2) {
            $this->changePassword($id, $data->password);
        }
    }
}