<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static ?PDO $db = null;

    protected static function db(): PDO
    {
        if (self::$db === null) {
            self::$db = Database::getConnection();
        }
        return self::$db;
    }
}
