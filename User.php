<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:50
 */

namespace User;


use Authorization\Authorization;
use Authorization\Permissions;
use Core\BussinesLogic;
use Core\WebSocket\Sender;
use User\Repository\UserRepository;

class User extends BussinesLogic
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
        if (isset($data->permission)) {
            $this->savePermissions($data->permission, $id);
        }
        if (!empty($data->password) && $data->password === $data->password2) {
            $this->changePassword($id, $data->password);
        }
        Sender::sendToUsers(["User", "User", "Update", $id]);
        (new \Authorization\Authorization())->refreshUserData();
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
        $salt = Authorization::generateSalt();
        $passwordHash = Authorization::hashPassword($password, $salt);
        $this->defaultDB->update($id, ['password' => $passwordHash, 'salt' => $salt]);
    }

    public function insert($data)
    {
        $filtered = $this->filterData($data);
        $id = $this->defaultDB->insert($filtered);
        $this->savePermissions($data->permission, $id);
        if (!empty($data->password) && $data->password === $data->password2) {
            $this->changePassword($id, $data->password);
        }
        return $id;
    }

    public function getAll()
    {
        return $this->defaultDB->getAll();
    }

    public function addPermission(int $idUser, string $group, string $name)
    {
        $this->defaultDB->insertPermission(['id_user' => $idUser, 'group' => $group, 'name' => $name]);
    }

    public function addAllPermissions(int $idUser)
    {
        $permissionsStructure = Permissions::readStructure();
        $prepared = [];
        foreach ($permissionsStructure as $group) {
            foreach ($group->children as $value) {
                $prepared[] = ['group' => $group->name, 'name' => $value->name, 'id_user' => $idUser];
            }
        }
        $this->defaultDB->savePermissions($prepared, $idUser);
    }
}
