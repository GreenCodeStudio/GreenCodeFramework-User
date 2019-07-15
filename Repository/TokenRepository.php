<?php

namespace User\Repository;

use Core\DB;


class TokenRepository extends \Core\Repository
{

    public function __construct()
    {
        parent::__construct('Token');
        $this->archiveMode = static::ArchiveMode_OnlyExisting;
    }
    public function getDataTable($options)
    {
        $start = (int)$options->start;
        $limit = (int)$options->limit;
        $sqlOrder = $this->getOrderSQL($options);
        $rows = DB::get("SELECT * FROM Token $sqlOrder LIMIT $start,$limit");
        $total = DB::get("SELECT count(*) as count FROM Token")[0]->count;
        return ['rows' => $rows, 'total' => $total];
    }
        private function getOrderSQL($options)
    {
        if (empty($options->sort))
            return "";
        else {
            $mapping = ['token'=> 'token', 'type'=> 'type', 'id_user'=> 'id_user', 'created'=> 'created', 'expire'=> 'expire', 'isOnce'=> 'isOnce'];
            if (empty($mapping[$options->sort->col]))
                throw new Exception();
            return ' ORDER BY '.DB::safeKey($mapping[$options->sort->col]).' '.($options->sort->desc ? 'DESC' : 'ASC').' ';
        }
    }
}