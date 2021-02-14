<div style="margin-top: 75px;">
    <form action="modify_nickname.php" method="POST">
        <div class="container">
            <h2>アカウント情報</h2>
        </div>

        <table class="container table table-bordered">
            <tr>
                <th>よんでID</th>
                <td><?= escape($login_user['user_name']) ?>　<a href="modify_user_name.php" class="small">変更はこちらから</a></td>
            </tr>

            <tr>
                <th>
                    <label for="new_nickname">ニックネーム</label>
                </th>
                <td>
                    <input type="text" placeholder="新しいニックネーム" name="new_nickname" id="new_nickname" value="<?= escape($login_user['nickname']) ?>" maxlength="16">
                    <ul class="text-dark small">
                        <?php if (isset($errors['new_nickname'])) : ?>
                            <li class="text-danger"><?= $errors['new_nickname'] ?></li>
                        <?php endif; ?>
                        <li>日本語もしくは英数字16文字以内</li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th>メールアドレス</th>
                <td><?= escape($login_user['email']) ?>　<a href="modify_email.php" class="small">変更はこちらから</a></td>
            </tr>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary">ニックネームを変更する</button></span>
        </div>
    </form>
</div>
