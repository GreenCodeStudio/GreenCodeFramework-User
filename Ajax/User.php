<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:51
 */

namespace User\Ajax;

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

    public function insert($data)
    {
        $this->will('user', 'add');
        $user = new \User\User();
        $user->insert($data);
    }
}