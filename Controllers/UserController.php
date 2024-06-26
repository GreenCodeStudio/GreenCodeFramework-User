<?php

namespace User\Controllers;

use Authorization\Authorization;
use Authorization\Permissions;
use Common\PageStandardController;
use Core\Exceptions\NotFoundException;

class UserController extends PageStandardController
{

    function index()
    {
        $this->will('user', 'show');
        $this->addView('User', 'list');
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);

    }


    /**
     * @param int $id
     * @throws \Authorization\Exceptions\NoPermissionException
     * @OfflineDataOnly
     */
    function edit(int $id)
    {
        $this->will('user', 'edit');
        $permissionsStructure = Permissions::readStructure();
        $this->addView('User', 'UserEdit', ['type' => 'edit', 'permissionsStructure' => $permissionsStructure]);
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);
        $this->pushBreadcrumb(['title' => 'Edycja', 'url' => '/User/edit/'.$id]);
    }

    function edit_data(int $id)
    {
        $this->will('user', 'edit');
        $user = new \User\User();
        $data = $user->getById($id);
        if ($data == null)
            throw new NotFoundException();
        $data->permission = $user->getPermissions($id);
        return ['user' => $data];
    }

    /**
     * @OfflineConstant
     */
    function add()
    {
        $this->will('user', 'add');
        $permissionsStructure = Permissions::readStructure();
        $this->addView('User', 'UserEdit', ['type' => 'add', 'permissionsStructure' => $permissionsStructure]);
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);
        $this->pushBreadcrumb(['title' => 'Dodaj', 'url' => '/User/add']);
    }

    function myAccount()
    {
        $this->pushBreadcrumb(['title' => 'Moje konto', 'url' => '/User/myAccount']);
        $user = ( new \User\User())->getById(Authorization::getUserId());
        $preferences=(new \User\UserPreferences())->getByUserId(Authorization::getUserId());
        $this->addView('User', 'myAccount', ['user' => $user, 'preferences'=>$preferences]);
    }
}
