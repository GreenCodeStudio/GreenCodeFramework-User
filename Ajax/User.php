<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:51
 */

namespace User\Ajax;

use Authorization\Authorization;
use Common\PageAjaxController;

class User extends PageAjaxController
{
    public function getTable($options)
    {
        $this->will('user', 'show');
        $user = new \User\User();
        return $user->getDataTable($options);
    }

    public function update($data)
    {
        $this->will('user', 'edit');
        $user = new \User\User();
        $user->update($data->id, $data);
    }

    public function updateMultiple(array $data)
    {
        $this->will('user', 'edit');
        $user = new \User\User();
        foreach ($data as $row) {
            $user->update($row->id, $row->data);
        }
    }

    public function insert($data)
    {
        $this->will('user', 'add');
        $user = new \User\User();
        $user->insert($data);
    }

    public function changeCurrentUserPassword(string $password, string $password2)
    {
        if (strlen($password) <6)
            throw new \InvalidArgumentException("Passwords too short");
        if (trim($password) !== $password)
            throw new \InvalidArgumentException("Whitespaces");
        if ($password !== $password2)
            throw new \InvalidArgumentException("Passwords not identical");

        (new \User\User())->changePassword(Authorization::getUserId(), $password);
    }

    public function updateCurrentUserPreference(string $name, string $value)
    {
        (new \User\UserPreferences())->updatePreference(Authorization::getUserId(), $name, $value);
    }
}
