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

        $filtered['isOnce'] = (int)isset($data->isOnce);
        $filtered['type'] = $data->type;
        $filtered['id_user'] = $data->id_user;

        return $filtered;
    }

    public function insert($data)
    {
        $now = (new \DateTime());
        $filtered = $this->filterData($data);
        $filtered['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        $filtered['created'] = $now->format("Y-m-d H:i:s");
        $filtered['expire'] = null;
        $id = $this->defaultDB->insert($filtered);
        \Core\WebSocket\Sender::sendToUsers(["User", "Token", "Insert", $id]);
    }

    public function getSelects()
    {
        $ret = [];
        $user = new Repository\UserRepository();
        $ret["user"] = $user->getSelect();
        return $ret;
    }
}