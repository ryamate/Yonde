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

function dropFamiliesTable($link)
{

    $dropTableSql = 'DROP TABLE IF EXISTS families;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 families' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 families' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropUsersTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS users;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 users' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 users' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropChildrenTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS children;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 children' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 children' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropPictureBooksTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS picture_books;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 picture_books' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 picture_books' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropStoredPictureBooksTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS stored_picture_books;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 stored_picture_books' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 stored_picture_books' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function dropReadRecordsTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS read_records;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo 'テーブル削除完了 read_records' . PHP_EOL;
    } else {
        echo 'Error: テーブル削除失敗 read_records' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createFamiliesTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE families (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        created_user_id INTEGER,
        family_name VARCHAR(100) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブル作成完了 families' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 families' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createUsersTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE users (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        family_id INTEGER NULL,
        user_name VARCHAR(100) UNIQUE,
        email VARCHAR(100) UNIQUE,
        password VARCHAR(100),
        user_image_path VARCHAR(100),
        introduction VARCHAR(1000),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブル作成完了 users' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 users' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createChildrenTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE children (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        family_id INTEGER NOT NULL,
        child_name VARCHAR(100),
        child_birthday TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (family_id) REFERENCES families(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブル作成完了 children' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 children' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createPictureBooksTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE picture_books (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        google_books_id VARCHAR(100) UNIQUE,
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
        echo 'テーブル作成完了 picture_books' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 picture_books' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createStoredPictureBooksTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE stored_picture_books (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        picture_book_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        five_star_rating INTEGER,
        read_status VARCHAR(100),
        summary VARCHAR(1000),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (picture_book_id) REFERENCES picture_books(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブル作成完了 stored_picture_books' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 stored_picture_books' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}

function createReadRecordsTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE read_records (
        id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
        stored_picture_book_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        memo VARCHAR(1000),
        read_date TIMESTAMP NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (stored_picture_book_id) REFERENCES stored_picture_books(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo 'テーブル作成完了 read_records' . PHP_EOL;
    } else {
        echo 'Error: テーブル作成失敗 read_records' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL;
    }
}


function createGuestFamily($link)
{
    $sql = <<<EOT
    INSERT INTO families (
        created_user_id,
        family_name,
        created_at
    )VALUES (
        1,
        "ゲス",
        NOW()
    )
    EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '追加完了 guest_family' . PHP_EOL;
    } else {
        echo 'Error: 追加失敗 guest_family' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

function createGuestUser($link)
{
    $sql = <<<EOT
    INSERT INTO users (
        family_id,
        user_name,
        email,
        password,
        user_image_path,
        introduction,
        created_at
    )VALUES (
        1,
        "ゲスト",
        "guest@guest",
        "guest_user1",
        "no_image_user_man.png",
        "ゲストユーザーです。",
        NOW()
    )
    EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '追加完了 guest_user' . PHP_EOL;
    } else {
        echo 'Error: 追加失敗 guest_user' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

function createGuestPartner($link)
{
    $sql = <<<EOT
    INSERT INTO users (
        family_id,
        user_name,
        email,
        password,
        user_image_path,
        introduction,
        created_at
    )VALUES (
        1,
        "ゲスミ",
        "guest@partner",
        "guest_partner1",
        "no_image_user_woman.png",
        "ゲストユーザーの妻です。",
        NOW()
    )
    EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '追加完了 guest_partner' . PHP_EOL;
    } else {
        echo 'Error: 追加失敗 guest_partner' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

function createGuestChild($link)
{
    $sql = <<<EOT
    INSERT INTO children (
        family_id,
        child_name,
        created_at
    )VALUES (
        1,
        "ゲスタロウ",
        NOW()
    )
    EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '追加完了 guest_child' . PHP_EOL;
    } else {
        echo 'Error: 追加失敗 guest_child' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

$link = dbConnect();
dropReadRecordsTable($link);
dropStoredPictureBooksTable($link);
dropPictureBooksTable($link);
dropChildrenTable($link);
dropUsersTable($link);
dropFamiliesTable($link);

createFamiliesTable($link);
createUsersTable($link);
createChildrenTable($link);
createPictureBooksTable($link);
createStoredPictureBooksTable($link);
createReadRecordsTable($link);

createGuestUser($link);
createGuestFamily($link);
createGuestPartner($link);
createGuestChild($link);

mysqli_close($link);
