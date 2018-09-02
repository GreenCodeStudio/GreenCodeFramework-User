<?php
/**
 * Created by PhpStorm.
 * User: matri
 * Date: 14.07.2018
 * Time: 13:50
 */

namespace User;


use Core\DB;

class User extends \Core\ReadModel
{
    public function __construct()
    {
        parent::__construct('user');
    }

    public function getDataTable($options)
    {
        $start = (int)$options->start;
        $limit = (int)$options->limit;
        $rows = DB::get("SELECT id,mail,name,surname FROM user LIMIT $start,$limit");
        return ['rows' => $rows];
    }

    public function getByUsername(string $username, bool $getSecretData = false)
    {
        if ($getSecretData)
            $select = ", salt, password";
        else
            $select = "";
        return DB::get("SELECT id,mail,name,surname $select FROM user WHERE mail = ?", [$username])[0] ?? null;
    }

    public function getById(int $id)
    {
        return DB::get("SELECT id,mail,name,surname FROM user WHERE id = ?", [$id])[0] ?? null;
    }
}