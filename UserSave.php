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
    }
    public function insert($data)
    {
        $filtered = $this->filterData($data);
        $db = new DB\User();
        $db->insert($filtered);
    }

    protected function filterData($data)
    {
        $ret = [];
        $ret['name'] = $data->name;
        $ret['surname'] = $data->surname;
        $ret['mail'] = $data->mail;
        return $ret;
    }
}