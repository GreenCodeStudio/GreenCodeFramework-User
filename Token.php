<?php

namespace User;

use User\Repository\TokenRepository;

class Token extends \Core\BussinesLogic
{
    public function __construct()
    {
        $this->defaultDB = new TokenRepository();
    }

    public function getDataTable($options)
    {
        return $this->defaultDB->getDataTable($options);
    }

    public function update(int $id, $data)
    {
        $filtered = $this->filterData($data);
        $this->defaultDB->update($id, $filtered);
        \Core\WebSocket\Sender::sendToUsers(["User", "Token", "Update", $id]);
    }

    protected function filterData($data)
    {


        return $ret;
    }

    public function insert($data)
    {
        $now = (new \DateTime());
        $ret = [];
        $filtered['token'] =  bin2hex(openssl_random_pseudo_bytes(16));
        $filtered['type'] = $data->type;
        $filtered['id_user'] = $data->id_user;
        $filtered['created'] = $now->format("Y-m-d H:i:s");
        $filtered['expire'] = null;
        $filtered['isOnce'] = (int)isset($data->isOnce);
        $id = $this->defaultDB->insert($filtered);
        \Core\WebSocket\Sender::sendToUsers(["User", "Token", "Insert", $id]);
    }

    public function getSelects()
    {
        $ret = [];
        $user = new Repository\userRepository();
        $ret["user"] = $user->getSelect();
        return $ret;
    }
}