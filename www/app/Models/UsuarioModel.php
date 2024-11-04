<?php

declare(strict_types=1);
namespace Com\Daw2\Models;

use http\Env;
use PDO;

class UsuarioModel
{

    public function __construct()
    {

        $host = $_ENV['DB.HOST'];
        $db   = $_ENV['DB.SCHEMA'];
        $user = $_ENV['DB.USER'];
        $pass = $_ENV['DB.PASS'];
        $charset = ;

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

}