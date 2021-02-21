<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/db_connect.php';

/**
 * picture_booksテーブルとやりとりするモデルクラス
 */
class PictureBook extends Dbc
{

    const MAX_DISPLAY_BOOKS = 10; // ページングにおいて、１ページに表示する件数

    /**
     * ログインユーザーの登録済み絵本を表示する
     */
    public function displayStoredPictureBooks($login_user, $page)
    {
        $dbh = $this->dbConnect();

        $start_no = ($page - 1) * self::MAX_DISPLAY_BOOKS;

        $stmt = $dbh->prepare('SELECT s.id, s.picture_book_id, s.five_star_rating, s.read_status, s.summary, s.created_at, s.updated_at, p.title, p.authors, p.thumbnail_uri, p.published_date FROM stored_picture_books s JOIN picture_books p ON s.picture_book_id = p.id WHERE s.user_id = :login_user_id ORDER BY s.updated_at DESC LIMIT :page,:max_display_books');

        $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':page', $start_no, PDO::PARAM_INT);
        $stmt->bindValue(':max_display_books', self::MAX_DISPLAY_BOOKS, PDO::PARAM_INT);

        $stmt->execute();

        $results = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
        $dbh = null;
    }

    /**
     * 登録済み絵本を登録解除する
     */
    public function deleteStoredPictureBook($login_user, $stored_picture_book)
    {
        $sql = 'DELETE FROM stored_picture_books WHERE id = :stored_picture_book_id AND user_id = :login_user_id';

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':stored_picture_book_id', (int)$stored_picture_book['id'], PDO::PARAM_INT);
            $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '絵本棚からの削除完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * ログインユーザーの登録済み絵本の Google Books ID を取得する
     */
    public function getStoredPictureBookGoogleBooksId($login_user)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT p.google_books_id, p.title FROM stored_picture_books s JOIN picture_books p ON s.picture_book_id = p.id WHERE user_id = :login_user_id');
        $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);

        $stmt->execute();

        $results = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
        $dbh = null;
    }

    /**
     * バリデーション処理: 絵本登録
     */
    public function validateCreatePictureBook($picture_book)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT google_books_id FROM picture_books WHERE google_books_id = :google_books_id');
        $stmt->bindValue(':google_books_id', $picture_book['google_books_id'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
        $dbh = null;
    }

    /**
     * 絵本を登録する
     */
    public function createPictureBook($picture_book)
    {
        $sql = <<<EOT
        INSERT INTO picture_books (
            google_books_id,
            title,
            authors,
            published_date,
            thumbnail_uri,
            created_at
        )VALUES (
            :google_books_id,
            :title,
            :authors,
            :published_date,
            :thumbnail_uri,
            NOW()
        )
        EOT;

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':google_books_id', $picture_book['google_books_id'], PDO::PARAM_STR);
            $stmt->bindValue(':title', $picture_book['title'], PDO::PARAM_STR);
            $stmt->bindValue(':authors', $picture_book['authors'], PDO::PARAM_STR);
            $stmt->bindValue(':published_date', $picture_book['published_date'], PDO::PARAM_STR);
            $stmt->bindValue(':thumbnail_uri', $picture_book['thumbnail_uri'], PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            echo '絵本登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * 絵本の picture_book_id を取得する
     */
    public function getPictureBookId($stored_picture_book)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT id FROM picture_books where google_books_id = :google_books_id');
        $stmt->bindValue(':google_books_id', $stored_picture_book['google_books_id'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            exit('絵本ID取得失敗');
        }
        return $result;
        $dbh = null;
    }

    /**
     * 絵本を本棚に登録する
     */
    public function storePictureBook($stored_picture_book, $login_user)
    {
        $sql = <<<EOT
        INSERT INTO stored_picture_books (
            picture_book_id,
            user_id,
            five_star_rating,
            read_status,
            summary,
            created_at
        )VALUES (
            :picture_book_id,
            :user_id,
            :five_star_rating,
            :read_status,
            :summary,
            NOW()
        )
        EOT;

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':picture_book_id', $stored_picture_book['id'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $login_user['id'], PDO::PARAM_STR);
            $stmt->bindValue(':five_star_rating', $stored_picture_book['five_star_rating'], PDO::PARAM_STR);
            $stmt->bindValue(':read_status', $stored_picture_book['read_status'], PDO::PARAM_STR);
            $stmt->bindValue(':summary', $stored_picture_book['summary'], PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            echo '絵本棚への登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * 登録済み絵本の評価などを変更する
     */
    public function modifyStorePictureBook($stored_picture_book)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE stored_picture_books SET five_star_rating = :five_star_rating, read_status = :read_status, summary = :summary WHERE id = :stored_picture_book_id');

            $stmt->bindValue(':five_star_rating', $stored_picture_book['five_star_rating'], PDO::PARAM_INT);
            $stmt->bindValue(':read_status', $stored_picture_book['read_status'], PDO::PARAM_STR);
            $stmt->bindValue(':summary', $stored_picture_book['summary'], PDO::PARAM_STR);
            $stmt->bindValue(':stored_picture_book_id', $stored_picture_book['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * バリデーション処理: 読み聞かせ記録
     */
    public function validateRecordRead(array $read_picture_book): array
    {
        // バリデーション結果のメッセージ
        $errors = [];
        if (mb_strlen($read_picture_book['memo']) > 140) {
            $errors['memo'] = '140文字以内 で入力してください';
        }

        return $errors;
    }


    /**
     * 登録済み絵本の評価などを変更する
     */
    public function recordReadPictureBook(array $read_picture_book)
    {
        $sql = <<<EOT
        INSERT INTO read_records (
            stored_picture_book_id,
            family_id,
            user_id,
            child_id,
            read_date,
            memo,
            created_at
            )VALUES (
            :stored_picture_book_id,
            :family_id,
            :user_id,
            :child_id,
            :read_date,
            :memo,
            NOW()
        )
        EOT;

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':stored_picture_book_id', $read_picture_book['stored_picture_book_id'], PDO::PARAM_STR);
            $stmt->bindValue(':family_id', $read_picture_book['family_id'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $read_picture_book['user_id'], PDO::PARAM_STR);
            $stmt->bindValue(':child_id', $read_picture_book['child_id'], PDO::PARAM_STR);
            $stmt->bindValue(':read_date', $read_picture_book['read_date'], PDO::PARAM_STR);
            $stmt->bindValue(':memo', $read_picture_book['memo'], PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            echo '絵本棚への登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * 絵本棚でよみきかせ記録を表示する
     */
    public function displayReadRecords(array $login_user, string $id_getting_read_record): array
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT id, child_id, memo, read_date FROM read_records WHERE stored_picture_book_id = :stored_picture_book_id AND user_id = :login_user_id');

        $stmt->bindValue(':stored_picture_book_id', (int)$id_getting_read_record, PDO::PARAM_INT);
        $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);

        $stmt->execute();

        $results = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
        $dbh = null;
    }

    /**
     * 一人のユーザーのよみきかせ記録の全情報を取得する
     */
    public function getReadRecords(array $login_user): array
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT id, stored_picture_book_id, family_id, user_id, child_id, memo, read_date FROM read_records WHERE user_id = :login_user_id');

        $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);

        $stmt->execute();

        $results = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
        $dbh = null;
    }
}
