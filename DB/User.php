<?php

namespace User\DB;

use Core\DB;


class User extends \Core\DBModel
{
    public function update(int $id, $data)
    {
        DB::update('User', $data, $id);
    }

    public function insert($data)
    {
        return DB::insert('User', $data);
    }

    public function savePermissions(array $prepared, int $idUser)
    {
        DB::beginTransaction();
        DB::query("DELETE FROM user_permission WHERE id_user = ?", [$idUser]);
        DB::insertMultiple('user_permission', $prepared);
        DB::commit();
    }
}