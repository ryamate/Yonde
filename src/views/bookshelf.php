<header>
    <div style="margin-top: 60px;">
        <!-- プロフィール表示 -->
        <section class="card-group p-4 container" style="max-width: 768px;">

            <div class="card border-0 text-center">
                <div class="card-body">
                    <a href="">
                        <?php if ($login_user['user_icon'] !== '') : ?>
                            <img src="assets/images/user_icon/<?= escape($login_user['user_icon']); ?>" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;border-radius: 50%;object-fit:cover;">
                        <?php else : ?>
                            <i class="far fa-user-circle fa-7x text-secondary"></i>
                            <!-- <img src="assets/images/user_icon/no_image_user_man.png" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;border-radius: 50%;object-fit:cover;"> -->
                        <?php endif; ?>
                    </a>
                    <div>
                        <a href="" class="card-link small text-teal1"><?= escape($login_user['nickname']); ?>さん</a>
                    </div>
                </div>
            </div>

            <div class="card border-0 text-center pt-3">
                <h5 class="card-title">えほんの棚</h5>
                <p class="card-text small">ファミリーメンバー</p>
                <div>
                    <a href="">
                        <i class="far fa-user-circle fa-3x text-dark"></i>
                    </a>
                    <a href="">
                        <i class="fas fa-child fa-3x text-dark"></i>
                    </a>
                </div>
            </div>

        </section>
        <!-- 集計ステータス -->
        <section>
            <div class="d-flex align-items-center justify-content-center mb-4" style="height: 60px; vertical-align: middle;">
                <div class="navbar-expand">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <p class="small">絵本登録数</p>
                            <p><?= $stored_picture_book_count; ?></p>
                        </li>
                        <li class="nav-item ml-4">
                            <p class="small">読んだ回数</p>
                            <p><?= count((array)$user_read_record_list); ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- 機能バー -->
        <section>
            <div class="d-flex align-items-center justify-content-center bg-light mb-4" style="height: 60px; vertical-align: middle;">
                <div class="navbar-expand ">
                    <ul class="navbar-nav">
                        <li class="nav-item ml-1">
                            <a href="" class="btn btn-teal1 btn-sm text-white small"><i class="fas fa-book-reader"></i>よみきかせ記録</a>
                        </li>
                        <li class="nav-item ml-1">
                            <a href="" class="btn btn-secondary btn-sm text-white "><i class="fas fa-clock"></i>タイムライン</a>
                        </li>
                        <li class="nav-item ml-1">
                            <a href="../users/profile_setting.php" class="btn btn-secondary btn-sm text-white "><i class="fas fa-cog"></i>プロフィール設定</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

    </div>
</header>

<main>
    <div class="container" style="max-width: 540px;">

        <!-- 絵本の記録表示 -->
        <?php if (count($display_read_records) > 0) : ?>
            <?php foreach ($display_read_records as $display_read_record) : ?>
                <section>
                    <div class="card mb-3">
                        <!-- 登録絵本情報 -->
                        <div class="row no-gutters">
                            <div class="col-sm-5">
                                <?php if ($display_read_record['thumbnail_uri'] !== '') : ?>
                                    <img src="<?= escape($display_read_record['thumbnail_uri']); ?>" alt="表紙イメージ" width="100%" height="100%" style="max-width: 300px; border-radius: 2px;">
                                <?php else : ?>
                                    <svg class="bd-placeholder-img" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image">
                                        <title>表紙のイメージがありません</title>
                                        <rect fill="#868e96" width="100%" height="100%" /><text fill="#dee2e6" dy=".3em" x="20%" y="50%">No Image</text>
                                    </svg>
                                    <!-- <span class="fa-stack text-secondary fa-5x">
                                        <i class="fas fa-book fa-stack-2x"></i>
                                        <i class="fa fa-stack-1x fa-inverse d-inline-block text-truncate ml-5" style="max-width: 120px;font-size:2px;"><?= escape($display_read_record['title']); ?></i>
                                    </span> -->
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title"><b><?= escape($display_read_record['title']); ?></b></h5>
                                    <p class="card-text">
                                        <?php if ($display_read_record['authors'] !== null) : ?>
                                            <?= escape($display_read_record['authors']); ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <?php if ($display_read_record['published_date'] !== null) : ?>
                                                <?= escape($display_read_record['published_date']); ?>発売
                                            <?php endif; ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- 絵本の読み聞かせ記録ボタン -->
                        <div class="card-body bg-light">
                            <form action="../picture_books/record_read_picture_book.php" method="POST">
                                <button type="submit" class="btn btn-teal1 btn-sm btn-block" title="絵本の読み聞かせ記録をする"><i class="fas fa-book-reader"></i>よみきかせの記録をする</button>
                                <input type="hidden" name="title" value="<?= $display_read_record['title'] ?>" />
                                <input type="hidden" name="authors" value="<?= $display_read_record['authors'] ?>" />
                                <input type="hidden" name="published_date" value="<?= $display_read_record['published_date'] ?>" />
                                <input type="hidden" name="thumbnail_uri" value="<?= $display_read_record['thumbnail_uri'] ?>" />
                                <input type="hidden" name="stored_picture_book_id" value="<?= $display_read_record['id'] ?>" />
                                <input type="hidden" name="five_star_rating" value="<?= $display_read_record['five_star_rating'] ?>" />
                                <input type="hidden" name="read_status" value="<?= $display_read_record['read_status'] ?>" />
                                <input type="hidden" name="summary" value="<?= $display_read_record['summary'] ?>" />
                            </form>
                        </div>


                        <!-- <div class="card border-0"> -->
                        <div class="card-body bg-light">
                            <h5 class="card-title small"><i class="fas fa-book-reader"></i><b>よみきかせ記録</b></h5>
                            <p class="card-text small">
                                <?php if (count($display_read_record) - 11 > 0) : ?>
                                    <?= count($display_read_record) - 11; ?>回よんだ

                                    <!-- <ul class="small" style="list-style: none;">
                                <i>

                                    <?php foreach (array_slice($display_read_record, 11) as $read_record) : ?>
                                        <li><?= date('Y年m月d日', strtotime($read_record['read_date'])); ?>、<?= $login_user['nickname']; ?>が<?= $read_record['child_id']; ?>によんだ。</li>
                                    <?php endforeach; ?>
                                </i>
                            </ul> -->
                                <?php else : ?>
                                    よみきかせ記録はまだありません
                                <?php endif; ?>
                            </p>
                        </div>
                        <!-- </div> -->

                        <div class="card-body pb-0 pr-0">
                            <h5 class="card-title small"><i class="far fa-edit"></i><b>レビュー</b></h5>
                            <p title="<?= date('Y-m-d', strtotime($display_read_record['created_at'])); ?>本棚登録">
                                <small class="text-muted">
                                    <i class="far fa-clock"></i><?= date('Y-m-d', strtotime($display_read_record['updated_at'])); ?>更新
                                </small>
                            </p>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12">
                                <div class="card border-0">
                                    <div class="card-body pt-0 pb-0">
                                        <?php if ($display_read_record['five_star_rating'] !== '0') : ?>
                                            <p class="small text-warning">
                                                <?php for ($i = 0; $i < (int)$display_read_record['five_star_rating']; $i++) : ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endfor; ?>
                                                <?php for ($i = 0; $i < 5 - (int)$display_read_record['five_star_rating']; $i++) : ?>
                                                    <i class="far fa-star"></i>
                                                <?php endfor; ?>
                                            </p>
                                        <?php else : ?>
                                            <p class="text-secondary">未評価</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card border-0">
                                    <div class="card-body pt-0 pb-0">
                                        <p class="mb-0">
                                            <small class="text-muted">
                                                よみきかせ状況： <?= escape($display_read_record['read_status']); ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body">
                                <p class="card-text small"><?php echo nl2br(escape($display_read_record['summary']), false); ?></p>
                            </div>
                        </div>
                        <!-- レビューを編集するボタン -->
                        <div class="row no-gutters">
                            <div class="col-sm-10">
                                <div class="card border-0">
                                    <div class="card-body pb-0">
                                        <form action="../picture_books/modify_stored_picture_book.php" method="POST">
                                            <button type="submit" class="btn btn-outline-teal1 bg-white text-teal1 btn-sm btn-block" title="レビュー（おすすめ度や感想）を編集する"><i class="far fa-edit"></i>レビューを編集する</button>
                                            <input type="hidden" name="title" value="<?= $display_read_record['title'] ?>" />
                                            <input type="hidden" name="authors" value="<?= $display_read_record['authors'] ?>" />
                                            <input type="hidden" name="published_date" value="<?= $display_read_record['published_date'] ?>" />
                                            <input type="hidden" name="thumbnail_uri" value="<?= $display_read_record['thumbnail_uri'] ?>" />
                                            <input type="hidden" name="stored_picture_book_id" value="<?= $display_read_record['id'] ?>" />
                                            <input type="hidden" name="five_star_rating" value="<?= $display_read_record['five_star_rating'] ?>" />
                                            <input type="hidden" name="read_status" value="<?= $display_read_record['read_status'] ?>" />
                                            <input type="hidden" name="summary" value="<?= $display_read_record['summary'] ?>" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- 登録絵本の削除ボタン -->
                            <div class="col-sm-2">
                                <div class="card border-0 text-right">
                                    <div class="card-body">
                                        <?php include $delete_stored_picture_book; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>


            <!-- ページング -->
            <div class="d-flex align-items-center justify-content-center">
                <?php if ($page >= 2) : ?>
                    <a href="bookshelf.php?page=<?= $page - 1; ?>" class="btn btn-outline-teal1 mr-1"><i class="fas fa-angle-double-left"></i></a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                    <?php if ($i === (int)$page) : ?>
                        <a class="btn btn-outline-secondary text-dark disabled mr-1"><?= $i; ?></a>
                    <?php else : ?>
                        <a href="bookshelf.php?page=<?= $i; ?>" class="btn btn-teal1 mr-1"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page <= $max_page - 1) : ?>
                    <a href="bookshelf.php?page=<?= $page + 1; ?>" class="btn btn-outline-teal1 mr-1"><i class="fas fa-angle-double-right"></i></a>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <p class="small">全<?= $stored_picture_book_count; ?>件中 <?= $start_no + 1; ?> - <?= $start_no + count($stored_picture_books) ?>件を表示</p>
            </div>

        <?php else : ?>
            <!-- 絵本登録が０冊の場合 -->
            <p>まだ絵本が登録されていません。</p>

        <?php endif; ?>
    </div>

</main>
