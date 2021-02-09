        <header>
            <div style="margin-top: 60px;">
                <section class="card-deck pb-4">
                    <div class="card border-0 d-flex align-items-end justify-content-center">
                        <div class="card-body">
                            <?php if ($login_user['user_image_path'] !== '') : ?>
                                <img src="assets/images/user_picture/<?= escape($login_user['user_image_path']); ?>" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;border-radius: 50%;object-fit:cover;">
                            <?php else : ?>
                                <img src="assets/images/user_picture/no_image_user_man.png" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;border-radius: 50%;object-fit:cover;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card border-0 d-flex align-items-start justify-content-center">
                        <p class="card-title h5"><?= escape($login_user['user_name']); ?>ファミリーの本棚</p>
                        <p class="card-title"><?= escape($login_user['user_name']); ?>さん</p>
                    </div>
                    <div class="card border-0 d-flex align-items-top justify-content-center">
                        <p class=" card-title"><?= escape($login_user['user_name']); ?>さんの家族</p>
                        <img src="assets/images/user_picture/no_image_user_woman.png" alt="プロフィール画像" style="width: 60px; height:60px;background-position: center center;border-radius: 50%;object-fit:cover;">
                    </div>
                </section>
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
                                    <p>1234</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="d-flex align-items-center justify-content-center bg-light mb-4" style="height: 60px; vertical-align: middle;">
                        <div class="navbar-expand ">
                            <ul class="navbar-nav">
                                <li class="nav-item ml-1">
                                    <a href="" class="btn btn-info btn-sm text-white small"><i class="fas fa-pen"></i>読み聞かせ記録</a>
                                </li>
                                <li class="nav-item ml-1">
                                    <a href="" class="btn btn-secondary btn-sm text-white "><i class="fas fa-user-circle"></i>プロフィール</a>
                                </li>
                                <li class="nav-item ml-1">
                                    <a href="" class="btn btn-secondary btn-sm text-white "><i class="fas fa-clock"></i>タイムライン</a>
                                </li>
                                <li class="nav-item ml-1">
                                    <a href="" class="btn btn-secondary btn-sm text-white "><i class="fas fa-cog"></i>設定</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </header>
        <main>
            <div class="container">
                <?php if (count($stored_picture_books) > 0) : ?>
                    <?php foreach ($stored_picture_books as $stored_picture_book) : ?>
                        <section>
                            <div class="pt-3 pr-4 pl-4 mb-4 bg-light">
                                <div class="card-deck bg-white">
                                    <div class="card col-md-3 border-0 d-flex align-items-center justify-content-center bg-white">
                                        <div class="card-body bg-white">
                                            <?php if ($stored_picture_book['thumbnail_uri'] !== '') : ?>
                                                <img src="<?= escape($stored_picture_book['thumbnail_uri']); ?>" alt="表紙イメージ" style="border-radius: 2px;">
                                            <?php else : ?>
                                                <span class="fa-stack text-info fa-5x">
                                                    <i class="fas fa-book fa-stack-2x"></i>
                                                    <i class="fa fa-stack-1x fa-inverse d-inline-block text-truncate ml-5" style="max-width: 120px;font-size:2px;"><?= escape($stored_picture_book['title']); ?></i>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card col-md-6 border-0 d-flex align-items-left justify-content-center bg-white">
                                        <div class="card-body bg-white">
                                            <h5 class="card-title"><?= escape($stored_picture_book['title']); ?></h5>
                                            <div class="card-text">
                                                <div>
                                                    <p>
                                                        <?php if ($stored_picture_book['authors'] !== null) : ?>
                                                            <?= escape($stored_picture_book['authors']); ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <?php if ($stored_picture_book['published_date'] !== null) : ?>
                                                            <?= escape($stored_picture_book['published_date']); ?>発売
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-md-3 border-0 d-flex align-items-left justify-content-center bg-white">
                                        <div class="card-body d-flex align-items-end justify-content-end bg-white">
                                            <form action="../picture_books/modify_stored_picture_book.php" method="POST">
                                                <input type="hidden" name="title" value="<?= $stored_picture_book['title'] ?>" />
                                                <input type="hidden" name="authors" value="<?= $stored_picture_book['authors'] ?>" />
                                                <input type="hidden" name="published_date" value="<?= $stored_picture_book['published_date'] ?>" />
                                                <input type="hidden" name="thumbnail_uri" value="<?= $stored_picture_book['thumbnail_uri'] ?>" />
                                                <input type="hidden" name="stored_picture_book_id" value="<?= $stored_picture_book['id'] ?>" />
                                                <input type="hidden" name="five_star_rating" value="<?= $stored_picture_book['five_star_rating'] ?>" />
                                                <input type="hidden" name="read_status" value="<?= $stored_picture_book['read_status'] ?>" />
                                                <input type="hidden" name="summary" value="<?= $stored_picture_book['summary'] ?>" />
                                                <button type="submit" class="btn btn-info btn-sm small" title="読み聞かせ記録"><i class="fas fa-pen"></i></a>
                                            </form>
                                            <!-- 登録絵本の削除ボタン -->
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#deleteId<?= $stored_picture_book['id'] ?>" title="本棚から削除する"><i class="fas fa-trash-alt"></i></button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteId<?= $stored_picture_book['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteIdLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteIdLabel">削除の確認</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            『<?= $stored_picture_book['title'] ?>』を本棚から削除してもよろしいですか？
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                                            <form action="../picture_books/delete_stored_picture_book.php" method="POST">
                                                                <button type="submit" class="btn btn-danger">OK</button>
                                                                <input type="hidden" name="stored_picture_book_id" value="<?= $stored_picture_book['id'] ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 mt-4 bg-white">
                                    <div>
                                        <p class="small"><i class="far fa-clock"></i><?= date('Y年m月d日', strtotime($stored_picture_book['updated_at'])); ?></p>
                                    </div>
                                    <div>
                                        <?php if ($stored_picture_book['five_star_rating'] !== '0') : ?>
                                            <p class="small text-warning">
                                                <?php for ($i = 0; $i < (int)$stored_picture_book['five_star_rating']; $i++) : ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endfor; ?>
                                                <?php for ($i = 0; $i < 5 - (int)$stored_picture_book['five_star_rating']; $i++) : ?>
                                                    <i class="far fa-star"></i>
                                                <?php endfor; ?>
                                            </p>
                                        <?php else : ?>
                                            <p class="text-secondary">未評価</p>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p><?php echo nl2br(escape($stored_picture_book['summary']), false); ?></p>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <p>読書状況： <?= escape($stored_picture_book['read_status']); ?></p>
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
