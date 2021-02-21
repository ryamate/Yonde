<main>
    <div style="margin-top: 75px;">
        <div class="container">
            <h2>プロフィール画像設定</h2>

            <!--プロフィール画像を設定していない場合、ファイル選択、及び、設定ボタンを設置した画面を表示し、
            プロフィール画像を設定済みの場合、プロフィール画像表示、及び、削除ボタンを設置した画面を表示する-->
            <?php if ($login_user['user_icon'] === '') : ?>
                <form method="POST" action="modify_user_icon.php?action=update" enctype="multipart/form-data">
                    <!-- 画像アップロード → enctype="multipart/form-data" -->
                    <table class="container table table-bordered">
                        <tr>
                            <th><label for="image">プロフィール画像</label></th>
                            <td>
                                <input type="file" name="image" size="35" value="image" />
                                <ul class="text-dark small">
                                    <?php if (isset($errors['image'])) : ?>
                                        <li class="text-danger"><?= $errors['image'] ?></li>
                                    <?php endif; ?>
                                    <li>1MB以内 / 「.gif」または「.jpg」「.png」のみ</li>
                                    <li>最適なサイズは120pxの正方形です</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <p class="text-center">
                        <button type="submit" class="btn btn-sm bg-white btn-outline-primary text-decoration-none text-primary">プロフィール画像を設定する</button>
                    </p>
                </form>

            <?php else : ?>
                <form method="POST" action="modify_user_icon.php?action=delete">
                    <input type="hidden" name="_method" value="delete">
                    <table class="container table table-bordered">
                        <tr>
                            <th><label>プロフィール画像</label></th>
                            <td>
                                <img src="../assets/images/user_icon/<?= $login_user['user_icon']; ?>" alt="" class="img-thumbnail" style="width: 150px; height:150px;background-position: center center;object-fit:cover;">
                            </td>
                        </tr>
                    </table>

                    <p class="text-center">
                        <button type="submit" id="icon_delete_button" class="btn btn-sm bg-white btn-outline-danger text-decoration-none text-danger">プロフィール画像を削除する</button>
                    </p>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
