<main>
    <div class="container" style="margin-top: 90px; margin-bottom:60px;">
        <h2>よみきかせの記録</h2>
        <section>
            <div class="container">

                <div class="card-body bg-white">
                    <?php if ($read_picture_book["thumbnail_uri"] !== '') : ?>
                        <img src="<?= escape($read_picture_book['thumbnail_uri']); ?>" alt="表紙イメージ" style="border-radius: 2px;">
                    <?php else : ?>
                        <span class="fa-stack text-secondary fa-5x">
                            <i class="fas fa-book fa-stack-2x"></i>
                            <i class="fa fa-stack-1x fa-inverse d-inline-block text-truncate ml-5" style="max-width: 120px;font-size:2px;">No Image</i>
                        </span>
                    <?php endif; ?>
                </div>

                <h4 class="card-title">『<?= escape($read_picture_book["title"]); ?>』</h4>

                <div class="card-text">
                    <p><?= escape($read_picture_book["authors"]); ?>/<?= escape($read_picture_book["published_date"]); ?>出版</p>
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
                    <label for="read_date">よんだ日付</label>
                    <div>
                        <input type="date" id="today" name="read_date" max="2050-12-31">
                    </div>
                </div>
                <script type="text/javascript">
                    //今日の日時を表示
                    window.onload = function() {
                        //今日の日時を表示
                        var date = new Date()
                        var year = date.getFullYear()
                        var month = date.getMonth() + 1
                        var day = date.getDate()

                        var toTwoDigits = function(num, digit) {
                            num += ''
                            if (num.length < digit) {
                                num = '0' + num
                            }
                            return num
                        }

                        var yyyy = toTwoDigits(year, 4)
                        var mm = toTwoDigits(month, 2)
                        var dd = toTwoDigits(day, 2)
                        var ymd = yyyy + "-" + mm + "-" + dd;

                        document.getElementById("today").value = ymd;
                    }
                </script>

                <div class="form-group">
                    <label for="memo">ひとことメモ</label>
                    <textarea type="text" name="memo" id="memo" rows="1" maxlength="140" class="form-control"><?= escape($read_picture_book['memo']); ?></textarea>
                    <ul class="text-dark small">
                        <li>140字以内</li>
                    </ul>
                </div>
                <div>
                    <input type="hidden" name="stored_picture_book_id" value="<?= escape($read_picture_book['id']); ?>" />
                    <button type="submit" class="btn btn-primary mb-4">よみきかせ記録をする</button>
                </div>
            </form>
        </section>

        <section>
            <h5>これまでの『<?= escape($read_picture_book['title']);  ?>』のよみきかせ記録</h5>
            <ul style="list-style: none;">
                <i>
                    <li>2021年2月16日、ママがゆうきちによんだ。</li>
                    <li>2021年1月15日、パパがゆうきちによんだ。</li>
                    <li>2020年12月14日、ママがゆうきちによんだ。</li>
                    <li>2020年11月13日、パパがゆうきちによんだ。</li>
                </i>
            </ul>
        </section>
    </div>
</main>
