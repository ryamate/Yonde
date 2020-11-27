<?php

function dbConnect()
{
    $link = mysqli_connect('db', 'yonde_log', 'pass', 'yonde_log');
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $link;
}

function dropTable($link)
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

function createTable($link)
{
    $createTableSql = <<<EOT
CREATE TABLE picture_books (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  publisher VARCHAR(255),
  publication_date DATE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
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
dropTable($link);
createTable($link);
mysqli_close($link);
