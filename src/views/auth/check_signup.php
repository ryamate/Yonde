<main>
    <div class="container" style="margin-top: 90px;">
        <p>記入した内容を確認して、「新規登録する」ボタンをクリックしてください。</p>
        <form action="check_signup.php" method="POST">
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
                    非表示
                </dd>
                <dt>プロフィール画像</dt>
                <dd>
                    <?php if (isset($_SESSION['join']['image'])) : ?>
                        <img src="../assets/images/user_icon/<?= escape($_SESSION['join']['image']) ?>" alt="" style="width: 200px; height:200px;background-position: center center;border-radius: 50%;object-fit:cover;">
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
