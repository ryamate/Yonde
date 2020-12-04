<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>絵本検索</title>
</head>

<body>
    <div class="container">
        <h1>絵本の検索</h1>
        <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
        <p>例えば… パンやのろくちゃん や はらぺこあおむし や おしりたんてい など。</p>
        <form action="search_api.php" method="POST">
            <div>
                <label for="search">検索</label>
                <input type="text" id="search" name="search">
                <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2">検索する</button>
            </div>
        </form>
    </div>
</body>


</html>
