<main>
    <div class="container" style="margin-top: 90px; margin-bottom:60px;">
        <h2>登録情報の編集</h2>
        <section>
            <div class="container">
                <div>
                    <img src="<?= escape($picture_book["thumbnail_uri"]); ?>" alt="表紙イメージ">
                </div>
                <h4 class="card-title"><?= escape($picture_book["title"]); ?></h4>
                <div class="card-text">
                    <p><?= escape($picture_book["authors"]); ?>/<?= escape($picture_book["published_date"]); ?>出版</p>
                </div>
            </div>
            <form action="store_picture_book.php?action=store" method="POST">
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
                    <label for="five_star_rating">評価(5点満点)</label>
                    <select name="five_star_rating" id="five_star_rating" class="form-control" value="<?= $stored_picture_book['five_star_rating']; ?>">
                        <option value="">まだ評価しない</option>
                        <option value="1">★☆☆☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="4">★★★★☆</option>
                        <option value="5">★★★★★</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="summary">感想</label>
                    <textarea type="text" name="summary" id="summary" rows="5" class="form-control" value="<?= escape($stored_picture_book['summary']); ?>"></textarea>
                </div>
                <input type="hidden" name="google_books_id" value="<?= escape($picture_book['google_books_id']); ?>" />
                <button type="submit" class="btn btn-info mb-4">登録する</button>
            </form>
        </section>
    </div>
</main>
