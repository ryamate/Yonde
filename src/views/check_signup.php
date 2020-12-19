<main>
    <div class="container" style="margin-top: 90px;">
        <p>記入した内容を確認して、「新規登録する」ボタンをクリックしてください。</p>
        <form action="create_user.php" method="POST">
            <input type="hidden" name="action" value="submit" />
            <dl>
                <dt>メールアドレス</dt>
                <dd>
                    <?= escape($_SESSION['join']['email']); ?>
                    <?php if (isset($errors['email'])) : ?>
                        <div class="text-danger">
                            <p><?= $errors['email'] ?></p>
                        </div>
                    <?php endif; ?>

                </dd>
                <dt>よんでID</dt>
                <dd>
                    <?= escape($_SESSION['join']['user_name']); ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    <?php for ($i = 0; $i < mb_strlen($_SESSION['join']['password']); $i++) : ?>
                        *
                    <?php endfor; ?>
                </dd>
                <dt>プロフィール画像</dt>
                <dd>
                    <?php if (isset($_SESSION['join']['image'])) : ?>
                        <img src="images/user_picture/<?= escape($_SESSION['join']['image']) ?>" alt="">
                    <?php else : ?>
                        未選択
                    <?php endif; ?>
                </dd>
            </dl>
            <div>
                <a href="signup.php?action=rewrite">&laquo;&nbsp;修正する</a> | <button type="submit" class="btn bg-warning text-decoration-none text-white">新規登録する</button>
            </div>
        </form>
    </div>
</main>
