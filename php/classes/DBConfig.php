<?php
require_once VENDOR_AUTOLOAD_PATH;
class DBConfig
{
    private static $db_host = 'localhost';
    private static $db_name = 'admisiones_dev';
    private static $db_pass = 'Adm1s10n3s2021**';
    private static $db_user = 'admisionesUnitropico';

    private function serializeMysqlDsn()
    {
        return 'mysql:host=' . self::$db_host . ';dbname=' . self::$db_name . ';charset=utf8';
    }

    public function getPDOCreationParams()
    {
        return [self::serializeMysqlDsn(), self::$db_user, self::$db_pass];
    }

    private function serializeDoctrinePdoParameteres()
    {
        return [
            'dbname' => self::$db_name,
            'user' => self::$db_user,
            'password' => self::$db_pass,
            'host' => self::$db_host,
            'driver' => 'pdo_mysql'
        ];
    }

    public static function getDoctrineQueryBuilder()
    {
        $conn = \Doctrine\DBAL\DriverManager::getConnection(self::serializeDoctrinePdoParameteres());
        $queryBuilder = $conn->createQueryBuilder();
        return $queryBuilder;
    }
}
