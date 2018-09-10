<?php

namespace User\Controllers;

use Authorization\Permissions;

class User extends \Common\PageStandardController
{

    function index()
    {
        $this->addView('User', 'list');
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);

    }

    /**
     * @param int $id
     * @OfflineDataOnly
     */
    function edit(int $id)
    {
        $permissionsStructure=Permissions::readStructure();
        $this->addView('User', 'edit', ['type' => 'edit', 'permissionsStructure'=>$permissionsStructure]);
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);
        $this->pushBreadcrumb(['title' => 'Edycja', 'url' => '/User/edit/'.$id]);
    }

    function edit_data(int $id)
    {
        $user = new \User\User();
        $data = $user->getById($id);
        if ($data == null)
            throw new \Core\Exceptions\NotFoundException();
        return ['user' => $data];
    }

    /**
     * @OfflineConstant
     */
    function add()
    {
        $this->addView('User', 'edit', ['type' => 'add']);
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);
        $this->pushBreadcrumb(['title' => 'Dodaj', 'url' => '/User/add']);
    }
}
