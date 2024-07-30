<?php

namespace User\Repository;

use Core\Database\DB;
use Core\Repository;
use Exception;


class UserRepository extends Repository
{

    public function __construct()
    {
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
    public function getByUsernameForPasswordReset(string $username)
    {
        $archivedSQL = $this->getArchiveModeSQL();
        return DB::get("SELECT id,mail,reset_password_code, reset_password_expire FROM user WHERE mail = ? $archivedSQL", [$username])[0] ?? null;
    }

    protected function getArchiveModeSQL()
    {
        if ($this->archiveMode == self::ArchiveMode_OnlyExisting)
            return ' AND !archived';
        if ($this->archiveMode == self::ArchiveMode_OnlyRemoved)
            return ' AND archived';
        return '';

    }

    public function getById(int $id, bool $getSecretData = false)
    {
        $archivedSQL = $this->getArchiveModeSQL();
        if ($getSecretData)
            $select = ", salt, password";
        else
            $select = "";
        return DB::get("SELECT id,mail,name,surname $select FROM user WHERE id = ? $archivedSQL", [$id])[0] ?? null;
    }

    public function getPermissions(int $userId)
    {
        $data = DB::getArray("SELECT * FROM user_permission up WHERE id_user = ?", [$userId]);
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
        $sqlOrder = $this->getOrderSQL($options);
        $rows = DB::get("SELECT id,mail,name,surname FROM user $sqlOrder LIMIT $start,$limit");
        $total = DB::get("SELECT count(*) as count FROM user")[0]->count;
        return ['rows' => $rows, 'total' => $total];
    }

    private function getOrderSQL($options)
    {
        if (empty($options->sort))
            return "";
        else {
            $mapping = ['name' => 'name', 'surname' => 'surname', 'mail' => 'mail'];
            if (empty($mapping[$options->sort->col]))
                throw new Exception();
            return ' ORDER BY '.DB::safeKey($mapping[$options->sort->col]).' '.($options->sort->desc ? 'DESC' : 'ASC').' ';
        }
    }

    public function getSelect()
    {
        return DB::get("SELECT id, CONCAT(name, ' ', surname) as title FROM user");
    }

    public function defaultTable(): string
    {
        return "user";
    }

    public function getAll()
    {
        return DB::get("SELECT id, name, surname, mail from user");
    }

    public function insertPermission(array $array)
    {
        DB::insert('user_permission', $array);
    }

    public function setResetPasswordCode($id, int $code, \DateTime $expiration)
    {
        DB::update('user', ['reset_password_code' => $code, 'reset_password_expire' => $expiration->format('Y-m-d H:i:s')], $id);
    }
}
