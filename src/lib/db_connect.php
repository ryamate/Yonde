<?php

require __DIR__ . '/../vendor/autoload.php';

class Dbc
{
    protected function dbConnect()
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

    public function getLoginUser($user)
    {
        if (empty($user)) {
            exit('ユーザー情報が不正です。');
        }

        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT * FROM users WHERE user_name = :user_name');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            exit('ユーザー情報を取得できません。');
        }
        return $result;
        $dbh = null;
    }

    public function validateUserLogin($user, $encoded_password)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT user_name, password FROM users WHERE user_name = :user_name AND password = :encoded_password');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $stmt->bindValue(':encoded_password', $encoded_password, PDO::PARAM_STR);

        $stmt->execute();

        $registered_user = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        $errors = [];

        if (!strlen($user['user_name'])) {
            $errors['user_name'] = '*よんでID：入力願います。';
        }

        if (!strlen($user['password'])) {
            $errors['password'] = '*パスワード：入力願います。';
        }

        if (!$registered_user) {
            $errors['user'] = '*よんでID、パスワードを正しく入力願います。';
        }

        return $errors;
    }

    public function validateUserSignup($user, $file_name)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT email FROM users WHERE email = :user_email');
        $stmt->bindValue(':user_email', $user['email'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_email = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $dbh->prepare('SELECT user_name FROM users WHERE user_name = :user_name');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_user_name = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        $errors = [];

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = '*メールアドレス：入力された値が正しくありません。';
        } elseif (isset($registered_email['email'])) {
            $errors['email'] = '*メールアドレス：登録済みのメールアドレスです。';
        }

        if (!strlen($user['user_name'])) {
            $errors['user_name'] = '*よんでID：入力願います。';
        } elseif (strlen($user['user_name']) > 16) {
            $errors['user_name'] = '*よんでID：16文字以内 で入力願います。';
        } elseif (isset($registered_user_name['user_name'])) {
            $errors['user_name'] = '*よんでID："' . $registered_user_name['user_name'] . '"は、使用されています。';
        }

        if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $user['password'])) {
            $errors['password'] =  '*パスワード：半角英数字をそれぞれ1文字以上含んだ8文字以上で設定願います。';
        }

        if (!empty($file_name)) {
            $ext = substr($file_name, -3);
            if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png') {
                $errors['image'] = '* プロフィール画像：「.gif」または「.jpg」「.png」のファイルをアップロード願います。';
            }
        }

        return $errors;
    }

    public function createUser($user)
    {
        $sql = <<<EOT
        INSERT INTO users (
            user_name,
            email,
            password,
            user_image_path,
            created_at
        )VALUES (
            :user_name,
            :email,
            :password,
            :user_image_path,
            NOW()
        )
        EOT;

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $user['password'], PDO::PARAM_STR);
            $stmt->bindValue(':user_image_path', $user['user_image_path'], PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            echo 'ユーザー登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    public function createFamily($user)
    {
        $sql = <<<EOT
        INSERT INTO families (
            created_user_id,
            created_at
        )VALUES (
            :created_user_id,
            NOW()
        )
        EOT;
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':created_user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '家族登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    public function listStoredPictureBooks($login_user)
    {
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT s.id, s.picture_book_id, s.five_star_rating, s.read_status, s.possession, s.summary, s.created_at, s.updated_at, p.title, p.authors, p.thumbnail_uri, p.published_date FROM stored_picture_books s JOIN picture_books p ON s.picture_book_id = p.id WHERE user_id = :login_user_id');
        $stmt->bindValue(':login_user_id', (int)$login_user['id'], PDO::PARAM_INT);

        $stmt->execute();

        $results = [];
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
        $dbh = null;
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

    public function storePictureBook($stored_picture_book, $user_id)
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
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
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
}
