<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>絵本検索</title>
</head>

<body>
    <h1>絵本の検索</h1>
    <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
    <p>例えば… パンやのろくちゃん や はらぺこあおむし や えんとつ町のプペル など。</p>
    <form action="search_api.php" method="POST">
        <div>
            <label for="search">検索</label>
            <input type="text" id="search" name="search">
            <button type="submit">検索する</button>
        </div>
    </form>
</body>


</html>
