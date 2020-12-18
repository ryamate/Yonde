<main>
    <div class="container" style="margin-top: 90px;">
        <p>記入した内容を確認して、「新規登録する」ボタンをクリックしてください。</p>
        <form action="create_user.php" method="POST">
            <dl>
                <dt>メールアドレス</dt>
                <dd>
                    <?= escape($_SESSION['join']['email']); ?>
                </dd>
                <dt>よんでID</dt>
                <dd>
                    <?= escape($_SESSION['join']['user_name']); ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    ※表示されません
                </dd>
                <dt>写真</dt>
                <dd>

                </dd>
            </dl>
            <div>
                <a href="signup.php?action=rewrite">&laquo;&nbsp;修正する</a> | <button type="submit" class="btn bg-warning text-decoration-none text-white">新規登録する</button>
            </div>
        </form>
    </div>
</main>
