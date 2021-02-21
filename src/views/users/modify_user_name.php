<main>
    <div style="margin-top: 75px;">
        <form action="modify_user_name.php" method="POST">
            <div class="container">
                <h2>よんでIDの変更</h2>
            </div>

            <table class="container table table-bordered">
                <tr>
                    <th>現在のよんでID</th>
                    <td><?= escape($login_user['user_name']) ?></td>
                </tr>

                <tr>
                    <th>
                        <label for="new_user_name">新しいよんでID</label>
                    </th>
                    <td>
                        <input type="text" placeholder="新しいよんでID" name="new_user_name" id="new_user_name" value="<?= escape($check_user['new_user_name']); ?>" maxlength="16">
                        <ul class="text-dark small">
                            <?php if (isset($errors['new_user_name'])) : ?>
                                <li class="text-danger"><?= $errors['new_user_name'] ?></li>
                            <?php endif; ?>
                            <li>半角英数小文字3～16文字</li>
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
                <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary">よんでIDを変更する</button></span>
            </div>
        </form>
    </div>
</main>
