<?php
namespace User\Ajax;

class Token extends \Core\AjaxController
{
    public function getTable($options)
    {
        $this->will('user', 'showToken');
        $Token = new \User\Token();
        return $Token->getDataTable($options);
    }

    public function insert($data)
    {
        $this->will('user', 'addToken');
        $Token = new \User\Token();
        $id = $Token->insert($data);
    }
}