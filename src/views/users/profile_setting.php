<main>
    <div class="container" style="margin-top: 75px; max-width: 540px;">
        <form method=" POST" action="profile_setting.php">
            <h2>プロフィール設定</h2>
            <table class="container table table-bordered">
                <tr>
                    <th>よんでID</th>
                    <td><?= escape($login_user['user_name']) ?>　<a href="modify_user_name.php" class="small">変更はこちらから</a></td>
                </tr>

                <tr>
                    <th>ニックネーム</th>
                    <td><?= escape($login_user['nickname']) ?>　<a href="modify_nickname.php" class="small">変更はこちらから</a></td>
                </tr>

                <tr>
                    <th>プロフィール画像</th>
                    <td>
                        <?php if ($login_user['user_icon'] !== '') : ?>
                            <img src="../assets/images/user_icon/<?= escape($login_user['user_icon']); ?>" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;object-fit:cover;">
                        <?php else : ?>
                            <i class="far fa-user-circle fa-5x text-secondary"></i>
                        <?php endif; ?>
                        <a href="modify_user_icon.php" class="small">変更はこちらから</a>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="new_introduction">自己紹介</label>
                    </th>
                    <td>
                        <textarea name="new_introduction" id="new_introduction" class="form-control"><?= escape($login_user['introduction']); ?></textarea>
                        <ul class="text-dark small">
                            <?php if (isset($errors['new_introduction'])) : ?>
                                <li class="text-danger"><?= $errors['new_introduction'] ?></li>
                            <?php endif; ?>
                            <li>1000文字以内 / HTMLタグ使用不可</li>
                        </ul>

                        <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary ml-2">自己紹介文を更新する</button>

                    </td>
                </tr>
            </table>
        </form>

        <form method="POST" action="/setting/profile">
            <input type="hidden" name="_method" value="profile">
            <h2>ファミリー設定</h2>
            <table class="container table table-bordered">
                <tbody>
                    <tr>
                        <th>ファミリーネーム【機能追加予定】</th>
                        <td>---　<a href="" class="small">変更はこちらから</a></td>
                    </tr>

                    <tr>
                        <th>ファミリーメンバー【機能追加予定】</th>
                        <td>---　<a href="" class="small">変更はこちらから</a></td>
                    </tr>

                </tbody>
            </table>
        </form>

    </div>
</main>
