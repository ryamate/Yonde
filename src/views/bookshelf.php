        <header>
            <div style="margin-top: 60px; margin-bottom:60px;">
                <section class="card-deck shadow-sm mb-4">
                    <div class="card border-0 d-flex align-items-center justify-content-center">
                        <div class="card-body">
                            <?php if (isset($login_user['user_image_path'])) : ?>
                                <img src="images/user_picture/<?= escape($login_user['user_image_path']); ?>" alt="プロフィール画像" style="width: 100px;">
                            <?php else : ?>
                                <a href="" style="width: 100px;">
                                    <i class="far fa-user-circle"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <a href="" class="small">プロフィール設定</a>
                        </div>
                    </div>
                    <div class="card border-0 d-flex align-items-center justify-content-center">
                        <p class="card-title"><?= escape($login_user['user_name']); ?>さん</p>
                        <p>本棚の絵本</p>
                    </div>
                    <div class="card border-0"></div>
                </section>
                <div class="container">
                    <a href="search_picture_book.php" class="btn btn-teal1 mb-4">絵本をさがす</a>
                </div>
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
                                            <?php if ($stored_picture_book['thumbnail_uri'] !== null) : ?>
                                                <img src="<?= escape($stored_picture_book['thumbnail_uri']); ?>" alt="表紙イメージ">
                                            <?php else : ?>
                                                <?= 'no image'; ?>
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
                                            <a href="" class="btn btn-info btn-sm small"><i class="fas fa-pencil-alt"></i><i class="fas fa-plus"></i></a>

                                            <form action="delete_stored_picture_book.php" method="POST">
                                                <button type="submit" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                                                <input type="hidden" name="stored_picture_book_id" value="<?= $stored_picture_book['id'] ?>" />
                                            </form>
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
                <?php else : ?>
                    <div class="container">
                        <p>まだ絵本が登録されていません。</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
