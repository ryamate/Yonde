<main>
    <div class="container">
        <h1>Yondeの新規登録</h1>
        <h2>ようこそ、Yondeへ。</h2>
        <form action="create_user.php" method="POST">
            <!-- <?php if (count($errors)) : ?>
                <div class="text-danger">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?> -->
            <div class="form-group">
                <label for="email">email</label>
                <input class="form-control" type="email" id="email" name="email">
                <!-- <input class="form-control" type="email" id="email" name="email" value="<?= $anger['happened_date']; ?>"> -->

            </div>
            <div>

                <label for="user_name">user_name</label>
                <input type="user_name" name="user_name">
            </div>
            <div>

                <label for="password">password</label>
                <input type="password" name="password">
            </div>
            <button type="submit" class="btn btn-sm bg-warning text-decoration-none text-white font-weight-bold ml-2 mr2">新規登録する</button>
            <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
        </form>
    </div>
</main>
