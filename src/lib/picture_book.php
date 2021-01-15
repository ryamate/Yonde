<?php

declare(strict_types=1);

require_once __DIR__ . '/db_connect.php';

class PictureBook extends Dbc
{
    const MAX_DISPLAY_BOOKS = 10;

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

    public function deleteStoredPictureBook($login_user_id, $stored_picture_book_id)
    {
        $sql = 'DELETE FROM stored_picture_books WHERE id = :stored_picture_book_id AND user_id = :login_user_id';

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':stored_picture_book_id', (int)$stored_picture_book_id, PDO::PARAM_INT);
            $stmt->bindValue(':login_user_id', (int)$login_user_id, PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '絵本棚からの削除完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

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
}
