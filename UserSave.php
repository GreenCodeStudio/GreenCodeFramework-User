<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 17.07.2018
 * Time: 22:07
 */

namespace User;


class UserSave extends \Core\SaveModel
{
    public function update(int $id, $data)
    {
        $filtered = $this->filterData($data);
        $db = new DB\User();
        $db->update($id, $filtered);
        $this->savePermissions($data->permission, $id);
        if (!empty($data->password) && $data->password === $data->password2) {
            $this->changePassword($id, $data->password);
        }
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
        $db = new DB\User();
        $db->savePermissions($prepared, $idUser);
    }

    public function changePassword(int $id, $password)
    {

        $db = new DB\User();
        $salt = \Authorization\Authorization::generateSalt();
        $passwordhash = \Authorization\Authorization::hashPassword($password, $salt);
        $db->update($id, ['password' => $passwordhash, 'salt' => $salt]);
    }

    public function insert($data)
    {
        $filtered = $this->filterData($data);
        $db = new DB\User();
        $id = $db->insert($filtered);
        $this->savePermissions($data->permission, $id);
    }
}