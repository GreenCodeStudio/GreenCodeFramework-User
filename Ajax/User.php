<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:51
 */

namespace User\Ajax;

class User extends \Core\AjaxController
{
    public function getTable($options)
    {
        $user = new \User\User();
        return $user->getDataTable($options);
    }

    public function update($data)
    {
        dump($data);

        $userSave = new \User\UserSave();
        $userSave->update($data->id, $data);
    }
}