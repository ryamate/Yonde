<?php

declare(strict_types=1); // 厳密な型付けを宣言

require __DIR__ . '/../vendor/autoload.php';

/**
 * データベース接続機能
 */
class Dbc
{

    protected static function dbConnect(): PDO
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $db_host = $_ENV['DB_HOST'];
        $db_database = $_ENV['DB_DATABASE'];
        $data_source_name = "mysql:host=$db_host;dbname=$db_database;charset=utf8";

        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];

        try {
            $dbh = new PDO($data_source_name, $db_username, $db_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            // echo 'DB接続完了';
            // $dbh = null;
        } catch (PDOException $e) {
            echo 'DB接続失敗' . $e->getMessage();
            exit();
        };

        return $dbh;
    }
}
