<header>
    <div class="container" style="margin-top: 90px; margin-bottom:60px; max-width: 540px;">
        <h1>絵本の検索</h1>
        <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
        <p>例えば… パンやのろくちゃん や はらぺこあおむし など。</p>
        <form action="search_picture_book.php" method="POST" class="form-inline">
            <div class="input-group">
                <input type="text" id="search" name="search" class="form-control" placeholder="絵本をさがす" value="<?= escape($search_input); ?>">
                <div class="input-group-append">
                    <button class="btn btn-teal1" type="submit" id="search"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</header>

<main>
    <!-- 検索結果表示 -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <div class="container" style="max-width: 540px;">
            <h2>検索結果</h2>
            <?php if (count($display_searched_books) > 0) : ?>
                <?php foreach ($display_searched_books as $item_number => $item) : ?>
                    <?php $book_title = @$item["volumeInfo"]["title"]; ?>

                    <?php $authors_array = @$item["volumeInfo"]["authors"]; ?>
                    <?php if ($authors_array !== null) : ?>
                        <?php $authors = implode(",", $authors_array); ?>
                    <?php else : ?>
                        <?php $authors = null; ?>
                    <?php endif; ?>

                    <?php $published_date = @$item["volumeInfo"]["publishedDate"]; ?>
                    <?php $description = @$item["volumeInfo"]["description"]; ?>

                    <section class="card shadow-sm mb-4">
                        <!-- サムネイル -->
                        <div class="row no-gutters">
                            <div class="col-sm-5">
                                <div class="card-body p-0">
                                    <!-- <h5 class="card-title">No.<?= $item_number + 1; ?></h5> -->
                                    <?php $thumbnail_uri = @$item["volumeInfo"]["imageLinks"]["thumbnail"]; ?>
                                    <?php if ($thumbnail_uri !== null) : ?>
                                        <!-- <img src="<?= $thumbnail_uri; ?>" alt="表紙イメージ"> -->
                                        <img src="<?= $thumbnail_uri; ?>" alt="表紙イメージ" class="border-right border-bottom" width="100%" height="100%" style="max-width: 280px; border-radius: 2px;">
                                    <?php else : ?>
                                        <svg class="bd-placeholder-img" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image">
                                            <title>表紙のイメージがありません</title>
                                            <rect fill="#868e96" width="100%" height="100%" /><text fill="#dee2e6" dy=".3em" x="20%" y="50%">No Image</text>
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <!-- 登録ボタン -->
                                <div class="card-body">
                                    <?php $google_books_id = @$item["id"]; ?>
                                    <?php if (in_array($google_books_id, array_column($stored_picture_books, 'google_books_id'))) : ?>
                                        <form action="" method="POST">
                                            <button type="submit" class="btn btn-secondary btn-block shadow mt-2 mb-2"><i class="far fa-check-square"></i> 本棚に登録済</button>

                                        </form>
                                    <?php else : ?>
                                        <form action="store_picture_book.php" method="POST">
                                            <button type="submit" class="btn btn-teal1 shadow btn-block mt-2 mb-2"><i class="fas fa-plus-square"></i> 本棚にいれる</button>
                                            <input type="hidden" name="google_books_id" value="<?= $google_books_id ?>" />
                                            <input type="hidden" name="title" value="<?= $book_title ?>" />
                                            <input type="hidden" name="authors" value="<?= $authors ?>" />

                                            <input type="hidden" name="published_date" value="<?= $published_date ?>" />
                                            <input type="hidden" name="thumbnail_uri" value="<?= $thumbnail_uri ?>" />
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- タイトル・作者・出版年月・説明 -->
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h4 class="card-title"><?= $book_title; ?></h4>
                                    <div class="card-text">
                                        <p>
                                            <?php if ($authors !== null) : ?>
                                                <?= $authors; ?>
                                            <?php endif; ?>
                                            <?php if ($published_date !== null) : ?>
                                                /<?= $published_date; ?>出版
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div>

                                        <?php if ($description !== null) : ?>
                                            <p class="small">
                                                <?= trimWord($description); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>

                <!-- ページング -->
                <div class="d-flex align-items-center justify-content-center">
                    <?php if ($page >= 2) : ?>
                        <form action="search_picture_book.php?page=<?= $page - 1; ?>" method="POST" class="mr-1">
                            <input type="hidden" name="search" value="<?= $search_input; ?>">
                            <button class="btn btn-outline-teal1" type="submit" id="search"><i class="fas fa-angle-double-left"></i></button>
                        </form>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                        <?php if ($i === (int)$page) : ?>
                            <a class="btn btn-outline-secondary text-dark disabled mr-1"><?= $i; ?></a>
                        <?php else : ?>
                            <form action="search_picture_book.php?page=<?= $i; ?>" method="POST" class="mr-1">
                                <input type="hidden" name="search" value="<?= $search_input; ?>">
                                <button class="btn btn-teal1" type="submit" id="search"><?= $i; ?></button>
                            </form>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page <= $max_page - 1) : ?>
                        <form action="search_picture_book.php?page=<?= $page + 1; ?>" method="POST">
                            <input type="hidden" name="search" value="<?= $search_input; ?>">
                            <button class="btn btn-outline-teal1" type="submit" id="search"><i class="fas fa-angle-double-right"></i></button>
                        </form>
                    <?php endif; ?>

                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="small">全<?= $searched_books_count; ?>件中 <?= $start_no + 1; ?> - <?= $start_no + count($display_searched_books) ?>件を表示</p>
                </div>
            <?php else : ?>
                <p>検索結果は0件です。</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>
