<div style="margin-top: 75px;">
    <form method="POST" action="modify_introduction.php">
        <div class="container">
            <h2>プロフィール設定</h2>
        </div>

        <table class="container table table-bordered">
            <tr>
                <th>よんでID</th>
                <td><?= escape($login_user['user_name']) ?>　<a href="modify_user_name.php">変更はこちらから</a></td>
            </tr>

            <tr>
                <th>ニックネーム</th>
                <td><?= escape($login_user['nickname']) ?>　<a href="modify_nickname.php">変更はこちらから</a></td>
            </tr>

            <tr>
                <th>プロフィール画像</th>
                <td>
                    <img src="../assets/images/user_icon/<?= $login_user['user_icon'] !== '' ? escape($login_user['user_icon']) : 'no_image_user_man.png'; ?>" alt="" class="img-thumbnail" style="width: 100px; height:100px;background-position: center center;object-fit:cover;">　
                    <a href="modify_user_icon.php">変更はこちらから</a>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="introduction">自己紹介</label>
                </th>
                <td>
                    <textarea name="introduction" id="introduction" class="form-control"><?= $login_user['introduction'] ?></textarea>
                    <ul>
                        <li>1000文字以内 / HTMLタグ使用不可</li>
                    </ul>

                    <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary ml-2">自己紹介文を更新する</button>

                </td>
            </tr>
        </table>
    </form>

    <form method="POST" action="/setting/profile">
        <input type="hidden" name="_method" value="profile">

        <div class="container">
            <h2>ファミリー設定</h2>
        </div>

        <table class="container table table-bordered">
            <tbody>
                <tr>
                    <th>ファミリーネーム【機能追加予定】</th>
                    <td>---　<a href="">変更はこちらから</a></td>
                </tr>

                <tr>
                    <th>ファミリーメンバー【機能追加予定】</th>
                    <td>---　<a href="">変更はこちらから</a></td>
                </tr>

            </tbody>
        </table>
    </form>

</div>
