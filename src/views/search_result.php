<header>
    <div class="container" style="margin-top: 90px; margin-bottom:60px;">
        <h1>絵本の検索</h1>
        <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
        <p>例えば… パンやのろくちゃん や はらぺこあおむし や おしりたんてい など。</p>
        <form action="search_result.php" method="POST" class="form-inline">
            <input type="text" id="search" name="search" class="form-control" placeholder="絵本を検索" value="<?= escape($search_input); ?>">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-teal1"><i class="fas fa-search"></i></button>
            </span>
        </form>
    </div>
</header>
<main>
    <div class="container">
        <h2>検索結果</h2>
        <?php if (count($searched_books) > 0) : ?>
            <?php foreach ($searched_books as $item_number => $item) : ?>
                <section class="card-deck shadow-sm mb-4">
                    <div class="card border-0 d-flex align-items-center justify-content-center">
                        <div class="card-body">
                            <!-- <h5 class="card-title">No.<?= $item_number + 1; ?></h5> -->

                            <?php $thumbnail_uri = @$item["volumeInfo"]["imageLinks"]["thumbnail"]; ?>
                            <?php if ($thumbnail_uri !== null) : ?>
                                <img src="<?= $thumbnail_uri; ?>" alt="表紙イメージ">
                            <?php else : ?>
                                <?= 'no image'; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card border-0 d-flex align-items-center justify-content-center">
                        <?php $book_title = @$item["volumeInfo"]["title"]; ?>
                        <h4 class="card-title"><?= $book_title; ?></h4>
                        <div class="card-text">
                            <?php $authors_array = @$item["volumeInfo"]["authors"]; ?>
                            <p>
                                <?php if ($authors_array !== null) : ?>
                                    <?php $authors = implode(",", $authors_array); ?>
                                    <?= $authors; ?>
                                <?php else : ?>
                                    <?= $authors = null; ?>
                                <?php endif; ?>

                                <?php $published_date = @$item["volumeInfo"]["publishedDate"]; ?>
                                <?php if ($published_date !== null) : ?>
                                    /<?= $published_date; ?>出版
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <?php $description = @$item["volumeInfo"]["description"]; ?>
                            <?php if ($description !== null) : ?>
                                <p>
                                    <?= $description; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card border-0 d-flex align-items-center justify-content-center">
                        <form action="create_picture_book.php" method="POST">
                            <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2"><i class="fas fa-plus-square"></i> 絵本棚に登録</button>
                            <?php $isbn_13 = @$item["volumeInfo"]["industryIdentifiers"][1]["identifier"]; ?>
                            <input type="hidden" name="isbn_13" value="<?= $isbn_13 ?>" />
                            <input type="hidden" name="title" value="<?= $book_title ?>" />
                            <input type="hidden" name="authors" value="<?= $authors ?>" />

                            <input type="hidden" name="published_date" value="<?= $published_date ?>" />
                            <input type="hidden" name="thumbnail_uri" value="<?= $thumbnail_uri ?>" />
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else : ?>
            <p>検索結果は0件です。</p>
        <?php endif; ?>
    </div>
</main>
