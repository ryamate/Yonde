<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../lib/escape.php';
require_once __DIR__ . '/../lib/user.php';
require_once __DIR__ . '/../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * ログインしているユーザーであるか判定し、ユーザー情報取得し、
 * 前回のsessionから１時間以上経過しているユーザーをログインページへ送る
 */
if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $user_model = new User;
    $login_user = $user_model->getLoginUser($user);
    $_SESSION = $login_user;
    // session時刻の更新
    $_SESSION['time'] = time();
} else {
    header('Location: ../auth/login.php');
    exit;
}

/**
 * リクエストされた表示するページ数を変数 $page へ代入し、ページングする
 */
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$picture_book_model = new PictureBook;
$start_no = ($page - 1) * $picture_book_model::MAX_DISPLAY_BOOKS;
$stored_picture_books = $picture_book_model->displayStoredPictureBooks($login_user, $page);
$stored_picture_book_count = count($stored_picture_books);
$max_page = ceil($stored_picture_book_count / $picture_book_model::MAX_DISPLAY_BOOKS);

/**
 * よみきかせ記録表示するための情報をread_recordsテーブルから取り出す
 */
// family_id （またはuser_idか）が一致するread_recordを取得する
if ($stored_picture_book_count === 0) {
    $read_records = [];
} else {
    foreach ($stored_picture_books as $stored_picture_book => $stored_picture_book_id) {
        // $stored_picture_book_ids['id'][] = $stored_picture_book['id'];
        $id_getting_read_record = $stored_picture_book_id['id'];
        $read_records[] = $picture_book_model->displayReadRecords($login_user, $id_getting_read_record);
    }
}

// $stored_picture_books の各絵本に読み聞かせ記録の配列をくっつける
$display_read_records = array_replace_recursive($stored_picture_books, $read_records);

$user_read_record_list =
    $picture_book_model->getReadRecords($login_user);
// $read_records_desc_date = array_multisort(array_map("strtotime", array_column($read_records, "read_date")), SORT_DESC, $read_records);
// $display_read_records = array_replace_recursive($stored_picture_books, $read_records_desc_date);

$title = '絵本棚-Yonde-よんで';
$content = __DIR__ . '/../views/bookshelf.php';
$delete_stored_picture_book = __DIR__ . '/../views/picture_books/delete_stored_picture_book.php';
include __DIR__ . '/../views/layout.php';
