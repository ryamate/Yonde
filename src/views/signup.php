<main>
    <div class="container" style="margin-top: 90px;">
        <h3>「よんで」の新規登録</h3>
        <h4>　ようこそ、「よんで」へ。</h4>
        <form action="create_user.php" method="POST">
            <?php if (count($errors)) : ?>
                <div class="text-danger">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input class="form-control" type="email" id="email" name="email" value="<?= $user['email']; ?>">
            </div>
            <div class="form-group">
                <label for="user_name">よんでID</label>
                <input class="form-control" type="user_name" id="user_name" name="user_name" value="<?= $user['user_name']; ?>">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input class="form-control" type="password" id="password" name="password" value="<?= $user['password']; ?>">
                <p class="text-dark">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
            </div>
            <button type="submit" class="btn bg-warning text-decoration-none text-white">新規登録する</button>
        </form>
    </div>
</main>
