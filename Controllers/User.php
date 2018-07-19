<?php

namespace User\Controllers;

class User extends \Common\PageStandardController
{

    function index()
    {
        $this->addView('User', 'list');
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);

    }

    function edit(int $id)
    {
        $this->addView('User', 'edit', ['type' => 'edit']);
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

    function add()
    {
        $this->addView('User', 'edit', ['type' => 'add']);
        $this->pushBreadcrumb(['title' => 'Użytkownicy', 'url' => '/User']);
        $this->pushBreadcrumb(['title' => 'Dodaj', 'url' => '/User/add']);
    }
}
