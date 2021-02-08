<main>
    <div class="container" style="margin-top: 90px;">
        <h3>「よんで」へログイン</h3>
        <div>
            <p>メールアドレスとパスワードを記入して、ログインしてください。</p>
        </div>
        <?php if (isset($errors['user'])) : ?>
            <div class="text-danger">
                <p><?= $errors['user'] ?></p>
            </div>
        <?php endif; ?>
        <div class="card container mt-4 p-4">
            <form action="login.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_name">よんでID</label>
                    <input class="form-control" type="user_name" id="user_name" name="user_name" value="<?= escape($user['user_name']); ?>">
                </div>
                <?php if (isset($errors['user_name'])) : ?>
                    <div class="text-danger">
                        <p><?= $errors['user_name'] ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input class="form-control" type="password" id="password" name="password" value="<?= escape($user['password']); ?>">
                    <?php if (isset($errors['password'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['password'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group pt-3">
                    <p>ログイン情報の記録</p>
                    <input id="save" type="checkbox" name="save" value="on">
                    <label for="save">次回からは自動的によんでIDを入力する</label>
                </div>
                <button type="submit" class="btn bg-teal1 text-decoration-none text-white">ログインする</button>
            </form>
        </div>
        <div class="card container mt-4 p-4">
            <form action="login.php?action=guest_user_login" method="POST" enctype="multipart/form-data">
                <div>
                    <p>* 新規登録がまだの方はこちら</p>
                    <a href="signup.php" class="btn btn-sm bg-warning btn-outline-warning text-decoration-none text-white" role="button">新規登録する</a>
                </div><br>
                <div>
                    <p class="text-teal1">* 新規登録せずに機能を試したい方はこちら</p>
                    <button type="submit" class="btn btn-sm bg-white btn-outline-teal1 text-decoration-none text-teal1">ゲストユーザーログイン</button>
                </div>
            </form>
        </div>
    </div>
</main>
