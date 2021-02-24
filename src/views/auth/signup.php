<main>
    <div class="container" style="margin-top: 90px; max-width: 540px;">
        <h3>「よんで」の新規登録</h3>
        <h4>　ようこそ、「よんで」へ。</h4><br>
        <p>次のフォームに必要事項を記入してください。</p>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="signup.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email"><span class="badge bg-warning text-white">必須</span> メールアドレス</label>
                    <input class="form-control" type="email" placeholder="メールアドレス" id="email" name="email" value="<?= escape($user['email']); ?>">
                    <?php if (isset($errors['email'])) : ?>
                        <ul class="text-danger">
                            <li><?= $errors['email'] ?></li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="user_name"><span class="badge bg-warning text-white">必須</span> よんでID</label>
                    <input class="form-control" type="user_name" placeholder="よんでID" id="user_name" name="user_name" value="<?= escape($user['user_name']); ?>" maxlength="16">
                    <?php if (isset($errors['user_name'])) : ?>
                        <ul class="text-danger">
                            <li><?= $errors['user_name'] ?></li>
                        </ul>
                    <?php else : ?>
                        <ul class="text-dark small">
                            <li>半角英数小文字3～16文字</li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password"><span class="badge bg-warning text-white">必須</span> パスワード</label>


                    <div class="toggle">
                        <input class="form-control js-password" type="password" placeholder="パスワード" id="password" name="password" value="<?= escape($user['password']); ?>" autocomplete="off" required="required">
                        <?php if (isset($errors['password'])) : ?>
                            <ul class="text-danger">
                                <li><?= $errors['password'] ?></li>
                            </ul>
                        <?php else : ?>
                            <ul class="text-dark small">
                                <?php if (isset($_SESSION['join']['password'])) : ?>
                                    <li class="text-danger">恐れ入りますが、パスワードを改めて入力してください</li>
                                <?php endif; ?>
                                <li>パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上</p>
                            </ul>
                        <?php endif; ?>
                        <div class="btn">
                            <input class="btn-input js-password-toggle" id="eye" type="checkbox">
                            <label class="btn-label js-password-label" for="eye"><i class="fas fa-eye"></i>パスワード表示</label>
                        </div>
                    </div>
                    <script>
                        const passwordToggle = document.querySelector('.js-password-toggle');
                        passwordToggle.addEventListener('change', function() {
                            const password = document.querySelector('.js-password'),
                                passwordLabel = document.querySelector('.js-password-label');
                            if (password.type === 'password') {
                                password.type = 'text';
                                passwordLabel.innerHTML = '<i class="fas fa-eye-slash"></i>パスワード表示しない';
                            } else {
                                password.type = 'password';
                                passwordLabel.innerHTML = '<i class="fas fa-eye"></i>パスワード表示';
                            }
                            password.focus();
                        });
                    </script>
                </div>

                <div class="form-group">
                    <label for="image"><span class="badge bg-white">任意</span>プロフィール画像</label><br>
                    <input type="file" name="image" size="35" value="image" />
                    <div class="text-danger">
                        <?php if (isset($errors['image'])) : ?>
                            <?php if ($errors['image'] === 'type') : ?>
                                <p><?= $errors['image'] ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($file_name) || isset($_SESSION['join']['image'])) : ?>
                            <ul>
                                <li>恐れ入りますが、画像を改めて選択してください</li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-block bg-warning text-decoration-none text-white">新規登録する</button>
            </form>
        </div>
        <div class="card container mt-4 p-4 shadow-sm">
            <form action="login.php?action=guest_user_login" method="POST" enctype="multipart/form-data">
                <p>新規登録せずに機能を試したい方はこちら</p>
                <button type="submit" class="btn btn-block btn-sm bg-white btn-outline-teal1 text-decoration-none text-teal1">ゲストユーザーログイン</button>
            </form>
        </div>
    </div>
</main>
