<main>
    <h2>登録情報の編集</h2>
    <section class="card-deck shadow-sm mb-4">
        <div class="card border-0 d-flex align-items-center justify-content-center">
            <div class="card-body">
                <img src="<?= $picture_book["thumbnail_uri"]; ?>" alt="表紙イメージ">
            </div>
        </div>
        <div class="card border-0 d-flex align-items-center justify-content-center">
            <h4 class="card-title"><?= $picture_book["title"]; ?></h4>
            <div class="card-text">
                <p><?= $picture_book["authors"]; ?>/<?= $picture_book["published_date"]; ?>出版</p>
            </div>
        </div>
        <div class="card border-0 d-flex align-items-center justify-content-center">
            <form action="register_details.php" method="POST">
                <?php $picture_book_id = @$item["volumeInfo"]["industryIdentifiers"][1]["identifier"]; ?>
                <input type="hidden" name="picture_book_id" value="<?= $picture_book_id ?>" />
                <input type="hidden" name="title" value="<?= $book_title ?>" />
                <input type="hidden" name="authors" value="<?= $authors = implode(",", $authors_array); ?>" />

                <input type="hidden" name="published_date" value="<?= $published_date ?>" />
                <input type="hidden" name="thumbnail_uri" value="<?= $thumbnail_uri ?>" />
            </form>
        </div>

        <form action="create.php" method="POST">
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
                        <input class="form-check-input" type="radio" name="read_status" id="read_status1" value="よみたい" <?php echo ($stored_picture_book['read_status'] === 'よみたい') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="read_status1">よみたい</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="read_status" id="read_status2" value="よんだ" <?php echo ($stored_picture_book['read_status'] === 'よんだ') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="read_status2">よんだ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="read_status" id="read_status3" value="なんども" <?php echo ($stored_picture_book['read_status'] === 'なんども') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="read_status3">なんども</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="read_score">評価(5点満点の整数)</label>
                <input type="number" name="read_score" id="read_score" class="form-control" value="<?php echo $stored_picture_book['read_score'] ?>">
            </div>
            <div class="form-group">
                <label for="review">感想</label>
                <textarea type="text" name="review" id="review" rows="10" class="form-control"><?php echo $stored_picture_book['review']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-4">登録する</button>
        </form>

    </section>
</main>
