<?php

namespace User\Controllers;

class User extends \Common\PageStandardController {

    function index() {
        $this->addView('User', 'list');

    }

    function edit(){
        $this->addView('User', 'edit');
    }
    function edit_data(int $id){
        $user = new \User\User();
        $data=$user->getById($id);
        if($data == null)
            throw new \Core\Exceptions\NotFoundException();
        return ['user'=>$data];
    }

}
