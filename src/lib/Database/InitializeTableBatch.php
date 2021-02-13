<?php

/**
 * 「よんで」のアプリケーション開発する際に、テーブルを初期化するためのプログラムです。
 *
 * 実行コマンド：
 * $ docker-compose exec app php lib/Database/InitializeTableBatch.php
 */

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../lib/db_connect.php';

/**
 * yonde_log データベースのテーブル初期化クラス
 */
class InitializeTableBatch extends Dbc
{
    public static function dropTable($table_name)
    {
        $dbh = self::dbConnect();
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $result = $dbh->query($sql);
        if ($result) {
            echo 'テーブル削除完了: ' . $table_name . PHP_EOL;
        } else {
            exit('Error: テーブル削除失敗: ' . $table_name . PHP_EOL);
        }
        $dbh = null;
    }

    public static function createTable($table_name)
    {
        $dbh = self::dbConnect();
        if ($table_name === 'families') {
            $sql = <<<EOT
            CREATE TABLE $table_name (
                id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
                created_user_id INTEGER,
                family_name VARCHAR(100) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) DEFAULT CHARACTER SET=utf8mb4;
            EOT;
        } elseif ($table_name === 'users') {
            $sql = <<<EOT
            CREATE TABLE $table_name (
                id INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
                family_id INTEGER NULL,
                user_name VARCHAR(100) UNIQUE,
                nickname VARCHAR(100),
                email VARCHAR(100) UNIQUE,
                password VARCHAR(100),
                user_icon VARCHAR(100),
                introduction VARCHAR(1000),
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) DEFAULT CHARACTER SET=utf8mb4;
            EOT;
        } elseif ($table_name === 'children') {
            $sql = <<<EOT
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
        } elseif ($table_name === 'picture_books') {
            $sql = <<<EOT
            CREATE TABLE $table_name (
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
        } elseif ($table_name === 'stored_picture_books') {
            $sql = <<<EOT
            CREATE TABLE $table_name (
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
        } elseif ($table_name === 'read_records') {
            $sql = <<<EOT
            CREATE TABLE $table_name (
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
        }
        $result = $dbh->query($sql);
        if ($result) {
            echo 'テーブル作成完了: ' . $table_name . PHP_EOL;
        } else {
            exit('Error: テーブル作成失敗: ' . $table_name . PHP_EOL);
        }
        $dbh = null;
    }

    public static function createGuestFamily()
    {
        $sql = <<<EOT
        INSERT INTO families (
            created_user_id,
            family_name,
            created_at
        )VALUES (
            1,
            "やまだ",
            NOW()
        )
        EOT;
        $dbh = self::dbConnect();
        $result = $dbh->query($sql);
        if ($result) {
            echo '追加完了: guest_family' . PHP_EOL;
        } else {
            exit('Error: 追加失敗: guest_family' . PHP_EOL);
        }
        $dbh = null;
    }

    public static function createGuestUser()
    {
        $sql = <<<EOT
        INSERT INTO users (
            family_id,
            user_name,
            nickname,
            email,
            password,
            user_icon,
            introduction,
            created_at
        )VALUES (
            1,
            "guest",
            "たろう",
            "guest@guest",
            "guest_user1",
            "no_image_user_man.png",
            "ゲストユーザーです。",
            NOW()
        )
        EOT;
        $dbh = self::dbConnect();
        $result = $dbh->query($sql);
        if ($result) {
            echo '追加完了: guest_user' . PHP_EOL;
        } else {
            exit('Error: 追加失敗: guest_user' . PHP_EOL);
        }
        $dbh = null;
    }

    public static function createGuestPartner()
    {
        $sql = <<<EOT
        INSERT INTO users (
            family_id,
            user_name,
            nickname,
            email,
            password,
            user_icon,
            introduction,
            created_at
        )VALUES (
            1,
            "partner",
            "はなこ",
            "guest@partner",
            "guest_partner1",
            "no_image_user_woman.png",
            "ゲストユーザーの妻です。",
            NOW()
        )
        EOT;
        $dbh = self::dbConnect();
        $result = $dbh->query($sql);
        if ($result) {
            echo '追加完了: guest_partner' . PHP_EOL;
        } else {
            exit('Error: 追加失敗: guest_partner' . PHP_EOL);
        }
        $dbh = null;
    }

    public static function createGuestChild()
    {
        $sql = <<<EOT
        INSERT INTO children (
            family_id,
            child_name,
            created_at
        )VALUES (
            1,
            "いちろう",
            NOW()
        )
        EOT;
        $dbh = self::dbConnect();
        $result = $dbh->query($sql);
        if ($result) {
            echo '追加完了: guest_child' . PHP_EOL;
        } else {
            exit('Error: 追加失敗: guest_child' . PHP_EOL);
        }
        $dbh = null;
    }
}

InitializeTableBatch::dropTable('read_records');
InitializeTableBatch::dropTable('stored_picture_books');
InitializeTableBatch::dropTable('picture_books');
InitializeTableBatch::dropTable('children');
InitializeTableBatch::dropTable('users');
InitializeTableBatch::dropTable('families');

InitializeTableBatch::createTable('families');
InitializeTableBatch::createTable('users');
InitializeTableBatch::createTable('children');
InitializeTableBatch::createTable('picture_books');
InitializeTableBatch::createTable('stored_picture_books');
InitializeTableBatch::createTable('read_records');

InitializeTableBatch::createGuestUser();
InitializeTableBatch::createGuestFamily();
InitializeTableBatch::createGuestPartner();
InitializeTableBatch::createGuestChild();
