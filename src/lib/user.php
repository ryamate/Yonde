<?php

declare(strict_types=1);

require_once __DIR__ . '/db_connect.php';

/**
 * usersテーブルとやりとりするモデルクラス
 */
class User extends Dbc
{
    /**
     * user_nameから、ユーザー情報を取得し、返す
     */
    //issue: 型を指定する
    public function getLoginUser($user)
    {
        if (empty($user)) {
            exit('ユーザー情報が不正です。');
        }

        $dbh = $this->dbConnect();

        // issue: '*' をカラム名ひとつずつに置き換え
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
            $errors['user_name'] = '*よんでID：入力してください。';
        }

        if (!strlen($user['password'])) {
            $errors['password'] = '*パスワード：入力してください。';
        }

        if (!$registered_user) {
            $errors['user'] = '*よんでID、パスワードを正しく入力してください。';
        }

        return $errors;
    }

    /**
     *
     */
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
            $errors['user_name'] = '*よんでID：入力してください。';
        } elseif (strlen($user['user_name']) > 16) {
            $errors['user_name'] = '*よんでID：16文字以内 で入力してください。';
        } elseif (isset($registered_user_name['user_name'])) {
            $errors['user_name'] = '*よんでID："' . $registered_user_name['user_name'] . '"は、使用されています。';
        }

        if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $user['password'])) {
            $errors['password'] =  '*パスワード：半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
        }

        if (!empty($file_name)) {
            $ext = substr($file_name, -3);
            if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png') {
                $errors['image'] = '* プロフィール画像：「.gif」または「.jpg」「.png」のファイルをアップロードしてください。';
            }
        }

        return $errors;
    }

    /**
     *
     */
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
}
