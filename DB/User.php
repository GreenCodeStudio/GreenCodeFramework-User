<?php
namespace User\DB;

use \Core\DB;


class User extends \Core\DBModel
{
    public function update(int $id, $data)
    {
        DB::update('User', $data, $id);
    }
}