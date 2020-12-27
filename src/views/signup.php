<main>
    <div class="container" style="margin-top: 90px;">
        <h3>「よんで」の新規登録</h3>
        <h4>　ようこそ、「よんで」へ。</h4>
        <div class="card container mt-4 p-4">
            <form action="signup.php" method="POST" enctype="multipart/form-data">
                <p>次のフォームに必要事項をご記入願います。</p>
                <div class="form-group">
                    <label for="email">メールアドレス <span class="badge bg-warning text-white">必須</span></label>
                    <input class="form-control" type="email" id="email" name="email" value="<?= escape($user['email']); ?>">
                </div>
                <?php if (isset($errors['email'])) : ?>
                    <div class="text-danger">
                        <p><?= $errors['email'] ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="user_name">よんでID <span class="badge bg-warning text-white">必須</span></label>
                    <input class="form-control" type="user_name" id="user_name" name="user_name" value="<?= escape($user['user_name']); ?>">
                </div>
                <?php if (isset($errors['user_name'])) : ?>
                    <div class="text-danger">
                        <p><?= $errors['user_name'] ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="password">パスワード <span class="badge bg-warning text-white">必須</span></label>
                    <input class="form-control" type="password" id="password" name="password" value="<?= escape($user['password']); ?>">
                    <?php if (isset($errors['password'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['password'] ?></p>
                        </div>
                    <?php else : ?>
                        <p class="text-dark small">* パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="image">プロフィール画像 <span class="badge bg-light">任意</span></label><br>
                    <input type="file" name="image" size="35" value="test" />
                    <div class="text-danger">
                        <?php if (isset($errors['image'])) : ?>
                            <?php if ($errors['image'] === 'type') : ?>
                                <p><?= $errors['image'] ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($file_name) || isset($_SESSION['join']['image'])) : ?>
                            <p>* 恐れ入りますが、画像を改めて選択願います。</p>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="btn bg-warning text-decoration-none text-white">新規登録する</button>
            </form>
        </div>
        <div class="card container mt-4 p-4">
            <form action="validate_login.php?action=test_user_login" method="POST" enctype="multipart/form-data">
                <p>* 新規登録せずに機能を試したい方はこちら</p>
                <button type="submit" class="btn bg-white btn-outline-teal1 text-decoration-none text-teal1">テストユーザーログイン</button>
            </form>
        </div>
    </div>

    </div>
</main>
