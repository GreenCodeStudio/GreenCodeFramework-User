<?php

namespace User\DB;

use Core\DB;


class UserDB extends \Core\DBModel
{

    public function __construct()
    {
        parent::__construct('user');
        $this->archiveMode = static::ArchiveMode_OnlyExisting;
    }

    public function savePermissions(array $prepared, int $idUser)
    {
        DB::beginTransaction();
        DB::query("DELETE FROM user_permission WHERE id_user = ?", [$idUser]);
        DB::insertMultiple('user_permission', $prepared);
        DB::commit();
    }

    public function getByUsername(string $username, bool $getSecretData = false)
    {
        $archivedSQL = $this->getArchiveModeSQL();
        if ($getSecretData)
            $select = ", salt, password";
        else
            $select = "";
        return DB::get("SELECT id,mail,name,surname $select FROM user WHERE mail = ? $archivedSQL", [$username])[0] ?? null;
    }

    protected function getArchiveModeSQL()
    {
        if ($this->archiveMode == self::ArchiveMode_OnlyExisting)
            return ' AND !archived';
        if ($this->archiveMode == self::ArchiveMode_OnlyRemoved)
            return ' AND archived';
        return '';

    }

    public function getById(int $id)
    {
        $archivedSQL = $this->getArchiveModeSQL();
        return DB::get("SELECT id,mail,name,surname FROM user WHERE id = ? $archivedSQL", [$id])[0] ?? null;
    }

    public function getPermissions(int $userId)
    {
        $data = DB::get("SELECT * FROM user_permission up WHERE id_user = ?", [$userId]);
        $ret = [];
        foreach ($data as $row) {
            $ret[$row['group']][$row['name']] = true;
        }
        return $ret;
    }

    public function getDataTable($options)
    {
        $start = (int)$options->start;
        $limit = (int)$options->limit;
        $rows = DB::get("SELECT id,mail,name,surname FROM user LIMIT $start,$limit");
        return ['rows' => $rows];
    }
}