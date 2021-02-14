<div style="margin-top: 75px;">
    <form action="modify_email.php" method="POST">
        <div class="container">
            <h2>メールアドレスの変更</h2>
        </div>

        <table class="container table table-bordered">
            <tr>
                <th>現在のメールアドレス</th>
                <td><?= escape($login_user['email']) ?></td>
            </tr>

            <tr>
                <th>
                    <label for="new_email">新しいメールアドレス</label>
                </th>
                <td>
                    <input type="text" placeholder="新しいメールアドレス" name="new_email" id="new_email" value="<?= escape($check_user['new_email']); ?>" maxlength="100">
                    <ul class="text-dark small">
                        <?php if (isset($errors['new_email'])) : ?>
                            <li class="text-danger"><?= $errors['new_email'] ?></li>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="password">パスワード</label>
                </th>
                <td>
                    <input type="password" placeholder="パスワード" name="password" id="password" value="">
                    <ul class="text-dark small">
                        <?php if (isset($errors['password'])) : ?>
                            <li class="text-danger"><?= $errors['password'] ?></li>
                        <?php endif; ?>
                        <li>確認のためにログインパスワードを入力してください</li>
                    </ul>
                </td>
            </tr>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary">メールアドレスを変更する</button></span>
        </div>
    </form>
</div>
