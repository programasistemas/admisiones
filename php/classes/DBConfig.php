<?php

class DBConfig
{
    private $db_host;
    private $db_name;
    private $db_pass;
    private $db_user;

    public function __construct()
    {
        $this->db_host = 'localhost';
        $this->db_name = 'admisiones_dev';
        $this->db_pass = 'Adm1s10n3s2021**';
        $this->db_user = 'admisionesUnitropico';
    }

    private function serializeMysqlDsn()
    {
        return "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";
    }

    public function getPDOCreationParams()
    {
        return [$this->serializeMysqlDsn(), $this->db_user, $this->db_pass];
    }
}
