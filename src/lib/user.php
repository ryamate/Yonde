<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/db_connect.php';

/**
 * usersテーブルとやりとりするモデルクラス
 */
class User extends Dbc
{
    /**
     * user_name を引数とし、ユーザー情報を取得し、返す
     */
    //issue: 型を指定する
    public function getLoginUser($user)
    {
        if (empty($user)) {
            exit('ユーザー情報が不正です');
        }

        $dbh = $this->dbConnect();

        // issue: '*' をカラム名ひとつずつに置き換える
        $stmt = $dbh->prepare('SELECT * FROM users WHERE user_name = :user_name');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            exit('ユーザー情報を取得できません');
        }
        return $result;
        $dbh = null;
    }

    /**
     * バリデーション処理: ログイン
     */
    public function validateUserLogin($user)
    {
        $encoded_password = sha1($user['password']);
        $dbh = $this->dbConnect();

        $stmt = $dbh->prepare('SELECT user_name, password FROM users WHERE user_name = :user_name AND password = :encoded_password');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $stmt->bindValue(':encoded_password', $encoded_password, PDO::PARAM_STR);

        $stmt->execute();

        $registered_user = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        $errors = [];

        if (!strlen($user['user_name'])) {
            $errors['user_name'] = 'よんでID：入力してください';
        }

        if (!strlen($user['password'])) {
            $errors['password'] = 'パスワード：入力してください';
        }

        if (!$registered_user) {
            $errors['user'] = 'よんでID、パスワード を正しく入力してください';
        }

        return $errors;
    }

    /**
     * バリデーション処理: 新規会員登録
     */
    public function validateUserSignup($user, $file_name)
    {
        $dbh = $this->dbConnect();

        // メールアドレスか登録済みでないかの確認
        $stmt = $dbh->prepare('SELECT email FROM users WHERE email = :user_email');
        $stmt->bindValue(':user_email', $user['email'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_email = $stmt->fetch(PDO::FETCH_ASSOC);
        // ユーザー名が登録済みでないかの確認
        $stmt = $dbh->prepare('SELECT user_name FROM users WHERE user_name = :user_name');
        $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_user_name = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        $errors = [];

        if (!strlen($user['email'])) {
            $errors['email'] = 'メールアドレスを入力してください';
        } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'メールアドレスの入力された値が正しくありません';
        } elseif (isset($registered_email['email'])) {
            $errors['email'] = '登録済みのメールアドレスです';
        }

        if (!strlen($user['user_name'])) {
            $errors['user_name'] = 'よんでIDを入力してください';
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $user['user_name'])) {
            $errors['user_name'] = 'よんでIDは半角英数小文字のみで入力してください';
        } else {
            if (strlen($user['user_name']) > 16 | strlen($user['user_name']) < 3) {
                $errors['user_name'] = 'よんでIDは半角英数小文字3～16文字で入力してください';
            } elseif (isset($registered_user_name['user_name'])) {
                $errors['user_name'] = 'よんでID"' . $registered_user_name['user_name'] . '"は、使用されています';
            }
        }

        if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $user['password'])) {
            $errors['password'] =  'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください';
        }

        if (!empty($file_name)) {
            $ext = substr($file_name, -3);
            if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png') {
                $errors['image'] = 'プロフィール画像は「.gif」または「.jpg」「.png」のファイルをアップロードしてください';
            }
        }

        return $errors;
    }

    /**
     * バリデーション処理: よんでID変更
     */
    public function validateModifyUsername($user)
    {
        $dbh = $this->dbConnect();

        // new_user_name が登録済みのものでないかの確認
        $stmt = $dbh->prepare('SELECT user_name FROM users WHERE user_name = :new_user_name');
        $stmt->bindValue(':new_user_name', $user['new_user_name'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_user_name = $stmt->fetch(PDO::FETCH_ASSOC); // 登録済みのものがある場合、その値が入る
        // 入力されたパスワードが、現在のよんでIDと紐づいたパスワードと一致するかを確認する
        $stmt = $dbh->prepare('SELECT password FROM users WHERE id = :user_id AND password = :encoded_password');
        $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_STR);
        $stmt->bindValue(':encoded_password', sha1($user['password']), PDO::PARAM_STR);
        $stmt->execute();
        $registered_user_password = $stmt->fetch(PDO::FETCH_ASSOC); // 登録済みのものと一致すれば、その値が入る
        $dbh = null;

        // バリデーション結果のメッセージ
        $errors = [];
        if (!strlen($user['new_user_name'])) {
            $errors['new_user_name'] = 'よんでIDを入力してください';
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $user['new_user_name'])) {
            $errors['new_user_name'] = 'よんでIDは半角英数小文字のみで入力してください';
        } else {
            if (strlen($user['new_user_name']) > 16 | strlen($user['new_user_name']) < 3) {
                $errors['new_user_name'] = 'よんでIDは半角英数小文字3～16文字で入力してください';
            } elseif (isset($registered_user_name['user_name'])) {
                $errors['new_user_name'] = 'よんでID"' . $registered_user_name['user_name'] . '"は、使用されています';
            }
        }

        if (!strlen($user['password'])) {
            $errors['password'] = 'パスワードを入力してください';
        } elseif (!$registered_user_password) {
            $errors['password'] = 'パスワードを正しく入力してください';
        }

        return $errors;
    }
    /**
     * バリデーション処理: メールアドレス変更
     */
    public function validateModifyEmail($user)
    {
        $dbh = $this->dbConnect();

        // new_email が登録済みのものでないかの確認
        $stmt = $dbh->prepare('SELECT email FROM users WHERE email = :new_email');
        $stmt->bindValue(':new_email', $user['new_email'], PDO::PARAM_STR);
        $stmt->execute();
        $registered_email = $stmt->fetch(PDO::FETCH_ASSOC); // 登録済みのものがある場合、その値が入る
        // 入力されたパスワードが、現在のよんでIDと紐づいたパスワードと一致するかを確認する
        $stmt = $dbh->prepare('SELECT password FROM users WHERE id = :user_id AND password = :encoded_password');
        $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_STR);
        $stmt->bindValue(':encoded_password', sha1($user['password']), PDO::PARAM_STR);
        $stmt->execute();
        $registered_user_password = $stmt->fetch(PDO::FETCH_ASSOC); // 登録済みのものと一致すれば、その値が入る
        $dbh = null;

        // バリデーション結果のメッセージ
        $errors = [];
        if (!strlen($user['new_email'])) {
            $errors['new_email'] = 'メールアドレスを入力してください';
        } elseif (!filter_var($user['new_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['new_email'] = 'メールアドレスの入力された値が正しくありません';
        } elseif (isset($registered_email['email'])) {
            $errors['new_email'] = 'メールアドレス"' . $registered_email['email'] . '"は、使用されています';
        }

        if (!strlen($user['password'])) {
            $errors['password'] = 'パスワードを入力してください';
        } elseif (!$registered_user_password) {
            $errors['password'] = 'パスワードを正しく入力してください';
        }

        return $errors;
    }

    /**
     * バリデーション処理: ニックネーム変更
     */
    public function validateModifyNickname($user)
    {
        // バリデーション結果のメッセージ
        $errors = [];
        if (!strlen($user['new_nickname'])) {
            $errors['new_nickname'] = 'ニックネーム：入力してください';
        } elseif (mb_strlen($user['new_nickname']) > 16) {
            $errors['new_nickname'] = 'ニックネーム：16文字以内 で入力してください';
        }

        return $errors;
    }

    /**
     * バリデーション処理: プロフィール画像設定
     */
    public function validateUserIconUpdate($file_name)
    {
        $errors = [];
        if (!empty($file_name)) {
            $ext = substr($file_name, -3);
            if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png') {
                $errors['image'] = '「.gif」または「.jpg」「.png」のファイルをアップロードしてください';
            }
        } elseif (empty($file_name)) {
            $errors['image'] = 'ファイルを選択してください';
        }

        return $errors;
    }

    /**
     * バリデーション処理: 自己紹介文変更
     *
     * profile_setting.php で使用
     */
    public function validateModifyIntroduction($user)
    {
        // バリデーション結果のメッセージ
        $errors = [];
        if (mb_strlen($user['new_introduction']) > 1000) {
            $errors['new_introduction'] = '1000文字以内 で入力してください';
        }

        return $errors;
    }

    /**
     * 新規会員登録処理
     */
    public function createUser($user)
    {
        $sql = <<<EOT
        INSERT INTO users (
            user_name,
            nickname,
            email,
            password,
            user_icon,
            created_at
        )VALUES (
            :user_name,
            :nickname,
            :email,
            :password,
            :user_icon,
            NOW()
        )
        EOT;

        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
            $stmt->bindValue(':nickname', $user['nickname'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $user['password'], PDO::PARAM_STR);
            $stmt->bindValue(':user_icon', $user['user_icon'], PDO::PARAM_STR);

            $stmt->execute();
            $dbh->commit();
            echo 'ユーザー登録完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * よんでID（user_name）を変更する
     */
    public function modifyUsername($user)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET user_name = :user_name WHERE id = :user_id');

            $stmt->bindValue(':user_name', $user['new_user_name'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * メールアドレスを変更する
     */
    public function modifyEmail($user)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET email = :email WHERE id = :user_id');

            $stmt->bindValue(':email', $user['new_email'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * ニックネームを変更する
     */
    public function modifyNickname($user)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET nickname = :nickname WHERE id = :user_id');

            $stmt->bindValue(':nickname', $user['new_nickname'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * プロフィール画像を追加する
     */
    public function updateUserIcon($user, $file_name)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET user_icon = :user_icon WHERE id = :user_id');

            $stmt->bindValue(':user_icon', $file_name, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * プロフィール画像の削除
     */
    public function deleteUserIcon($user)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET user_icon = :user_icon WHERE id = :user_id');

            $stmt->bindValue(':user_icon', "", PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    /**
     * 自己紹介を変更する
     */
    public function modifyIntroduction($user)
    {
        $dbh = $this->dbConnect();
        $dbh->beginTransaction();

        try {
            $stmt = $dbh->prepare('UPDATE users SET introduction = :introduction WHERE id = :user_id');

            $stmt->bindValue(':introduction', $user['new_introduction'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);

            $stmt->execute();
            $dbh->commit();
            echo '編集完了';
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
