<?php

namespace User\Controllers;

use Authorization\Permissions;
use Core\Exceptions\NotFoundException;

class Token extends \Common\PageStandardController
{

    function index()
    {
        $this->will('user', 'showToken');
        $this->addView('User', 'TokenList');
        $this->pushBreadcrumb(['title' => 'Token', 'url' => '/Token']);

    }

    /**
     * @param int $id
     */
    function view(int $id)
    {
        $Token = new \User\Token();
        $data = $Token->getById($id);
        if ($data == null)
            throw new NotFoundException();
        $this->addView('user', 'TokenView', ['data' => $data]);
        $this->pushBreadcrumb(['title' => 'Token', 'url' => '/Token']);
        $this->pushBreadcrumb(['title' => 'Podgląd', 'url' => '/Token/view/'.$id]);
    }

    /**
     * @OfflineConstant
     */
    function add()
    {
        $this->will('user', 'addToken');
        $permissionsStructure = Permissions::readStructure();
        $this->addView('User', 'TokenEdit', ['type' => 'add']);
        $this->pushBreadcrumb(['title' => 'Token', 'url' => '/Token']);
        $this->pushBreadcrumb(['title' => 'Dodaj', 'url' => '/Token/add']);
    }

    function add_data()
    {
        $this->will('user', 'addToken');
        $Token = new \User\Token();
        return ['selects' => $Token->getSelects()];
    }
}
