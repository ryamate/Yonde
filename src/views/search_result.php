        <h1>絵本の検索</h1>
        <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
        <p>例えば… パンやのろくちゃん や はらぺこあおむし や おしりたんてい など。</p>
        <form action="search_result.php" method="POST">
            <div>
                <label for="search">検索</label>
                <input type="text" id="search" name="search">
                <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <main>
            <div class="container">
                <h2>検索結果</h2>
                <?php if (count($searched_books) > 0) : ?>
                    <?php foreach ($searched_books as $item_number => $item) : ?>
                        <section class="card-deck shadow-sm mb-4">
                            <div class="card border-0 d-flex align-items-center justify-content-center">
                                <div class="card-body">
                                    <!-- <h5 class="card-title">No.<?= $item_number + 1; ?></h5> -->

                                    <?php $imageLink = @$item["volumeInfo"]["imageLinks"]["thumbnail"]; ?>
                                    <?php if ($imageLink !== null) : ?>
                                        <img src="<?= $imageLink; ?>" alt="表紙イメージ">
                                    <?php else : ?>
                                        <?= 'no image'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card border-0 d-flex align-items-center justify-content-center">
                                <?php $book_title = @$item["volumeInfo"]["title"]; ?>
                                <h4 class="card-title"><?= $book_title; ?></h4>
                                <div class="card-text">
                                    <?php $authors = @$item["volumeInfo"]["authors"]; ?>
                                    <p>
                                        <?php if ($authors !== null) : ?>
                                            <?php foreach ($authors as $author) : ?>
                                                <?= $author; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <?php $published_date = @$item["volumeInfo"]["publishedDate"]; ?>
                                        <?php if ($published_date !== null) : ?>
                                            /<?= $published_date; ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="card border-0 d-flex align-items-center justify-content-center">
                                <form action="register_details.php" method="POST">
                                    <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2"><i class="fas fa-plus-square"></i> 絵本棚に登録</button>
                                    <input type="hidden" name="title" value="<?= $book_title ?>" />
                                </form>
                            </div>
                        </section>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>検索結果は0件です。</p>
                <?php endif; ?>
            </div>
        </main>
