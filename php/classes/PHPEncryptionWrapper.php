<?php

require_once VENDOR_AUTOLOAD_PATH;

class PHPEncryptionWrapper
{
    private static $key = null;

    private function loadKey()
    {
        if (self::$key == null) {
            self::$key = Defuse\Crypto\Key::loadFromAsciiSafeString(file_get_contents(realpath(dirname(__DIR__, 2)) . '/php/config/encryption_key.txt'));
        }
    }

    public static function encrypt($string)
    {
        self::loadKey();
        return Defuse\Crypto\Crypto::encrypt($string, self::$key);
    }

    public static function decrypt($string)
    {
        self::loadKey();
        return Defuse\Crypto\Crypto::decrypt($string, self::$key);
    }
}
