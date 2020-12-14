<?php

require __DIR__ . '/../vendor/autoload.php';

function dbConnect()
{

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];

    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $link;
}

function dropPictureBooksTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS picture_books;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropStoredPictureBooksTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS stored_picture_books;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropUsersTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS users;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropFamiliesTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS families;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropReadRecordsTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS read_records;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropChildrenTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS children;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブルを削除しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}



function createPictureBooksTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE picture_books (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        isbn_13 VARCHAR(100) UNIQUE,
        title VARCHAR(255),
        authors VARCHAR(255),
        published_date VARCHAR(10),
        thumbnail_uri VARCHAR(1000),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createUsersTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE users (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        user_name VARCHAR(255),
        email VARCHAR(128) UNIQUE,
        password VARCHAR(255),
        introduction VARCHAR(1000),
        user_image_path VARCHAR(1000),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createFamiliesTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE families (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        user_id INTEGER UNIQUE NOT NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createChildrenTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE children (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        family_id INTEGER UNIQUE NOT NULL,
        child_name VARCHAR(1000),
        child_birthday TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (family_id) REFERENCES families(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createStoredPictureBooksTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE stored_picture_books (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        picture_book_id INTEGER UNIQUE NOT NULL,
        family_id INTEGER NOT NULL,
        five_star_rating INTEGER,
        read_status VARCHAR(100),
        review VARCHAR(1000),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (picture_book_id) REFERENCES picture_books(id),
        FOREIGN KEY (family_id) REFERENCES families(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createReadRecordsTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE read_records (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        stored_picture_book_id INTEGER UNIQUE NOT NULL,
        user_id INTEGER UNIQUE NOT NULL,
        summary VARCHAR(1000),
        read_date TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (stored_picture_book_id) REFERENCES stored_picture_books(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブルを作成しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}



$link = dbConnect();
dropReadRecordsTable($link);
dropStoredPictureBooksTable($link);
dropChildrenTable($link);
dropFamiliesTable($link);
dropUsersTable($link);
dropPictureBooksTable($link);

createPictureBooksTable($link);
createUsersTable($link);
createFamiliesTable($link);
createChildrenTable($link);
createStoredPictureBooksTable($link);
createReadRecordsTable($link);

mysqli_close($link);
