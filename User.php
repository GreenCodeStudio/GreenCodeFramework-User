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
        $rows = DB::get("SELECT * FROM user LIMIT $start,$limit");
        return ['rows' => $rows];
    }
}