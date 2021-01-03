<main>
    <div class="container" style="margin-top: 90px; margin-bottom:60px;">
        <h2>登録情報の編集</h2>
        <section>
            <div class="container">
                <div>
                    <img src="<?= escape($stored_picture_book["thumbnail_uri"]); ?>" alt="表紙イメージ">
                </div>
                <h4 class="card-title"><?= escape($stored_picture_book["title"]); ?></h4>
                <div class="card-text">
                    <p><?= escape($stored_picture_book["authors"]); ?>/<?= escape($stored_picture_book["published_date"]); ?>出版</p>
                </div>
            </div>
            <form action="modify_stored_picture_book.php?action=modify" method="POST">
                <?php if (count($errors)) : ?>
                    <div class="text-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?= $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="read_status">読書状況</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="read_status" id="read_status1" value="よみたい" <?= ($stored_picture_book['read_status'] === 'よみたい') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="read_status1">よみたい</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="read_status" id="read_status2" value="よんだ" <?= ($stored_picture_book['read_status'] === 'よんだ') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="read_status2">よんだ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input ass="form-check-input" type="radio" name="read_status" id="read_status3" value="なんども" <?= ($stored_picture_book['read_status'] === 'なんども') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="read_status3">なんども</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="five_star_rating">評価(5点満点の整数)</label>
                    <input type="number" name="five_star_rating" id="five_star_rating" class="form-control" value="<?= $stored_picture_book['five_star_rating']; ?>">
                </div>
                <div class="form-group">
                    <label for="summary">感想</label>
                    <textarea type="text" name="summary" id="summary" rows="5" class="form-control"><?= escape($stored_picture_book['summary']); ?></textarea>
                </div>
                <input type="hidden" name="stored_picture_book_id" value="<?= escape($stored_picture_book['stored_picture_book_id']); ?>" />
                <button type="submit" class="btn btn-teal1 mb-4">編集する</button>
            </form>
        </section>
    </div>
</main>
