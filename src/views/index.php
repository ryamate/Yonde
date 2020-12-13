<a href="search_new.php" class="btn btn-teal1 mb-4">絵本を検索する</a>
<main>
    <?php if (count($stored_picture_books) > 0) : ?>
        <?php foreach ($stored_picture_books as $stored_picture_book) : ?>
            <section class="card-deck shadow-sm mb-4">
                <div class="card border-0 d-flex align-items-center justify-content-center">
                    <div class="card-body">
                        <?php if ($stored_picture_book['thumbnail_uri'] !== null) : ?>
                            <img src="<?= escape($stored_picture_book['thumbnail_uri']); ?>" alt="表紙イメージ">
                        <?php else : ?>
                            <?= 'no image'; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card border-0 d-flex align-items-center justify-content-center">
                    <div class="card-body">
                        <h4 class="card-title"><?= escape($stored_picture_book['title']); ?></h4>
                        <div class="card-text">
                            <div>
                                <?php if ($stored_picture_book['authors'] !== null) : ?>
                                    <?= escape($stored_picture_book['authors']); ?>
                                <?php endif; ?>

                                <?php if ($stored_picture_book['published_date'] !== null) : ?>
                                    &nbsp;/&nbsp;
                                    <?= escape($stored_picture_book['published_date']); ?>出版
                                <?php endif; ?>
                            </div>
                            <div>
                                <?= escape($stored_picture_book['read_status']); ?>&nbsp;/&nbsp;
                                <?php if ($stored_picture_book['five_star_rating'] !== '0') : ?>
                                    <?= escape($stored_picture_book['five_star_rating']); ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                                点
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 d-flex align-items-center justify-content-center">
                    <div class="card-body">
                        <p>
                            <?php echo nl2br(escape($stored_picture_book['review']), false); ?>
                        </p>
                    </div>
                </div>

            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>まだ絵本が登録されていません。</p>
    <?php endif; ?>

</main>
