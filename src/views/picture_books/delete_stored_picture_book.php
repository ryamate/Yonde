<!-- bookshelf.php で使用 -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#deleteId<?= $stored_picture_book['id'] ?>" title="本棚から削除する"><i class="fas fa-trash-alt"></i></button>
<!-- Modal -->
<div class="modal fade" id="deleteId<?= $stored_picture_book['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteIdLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteIdLabel">削除の確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                『<?= $stored_picture_book['title'] ?>』を本棚から削除してもよろしいですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <form action="../picture_books/delete_stored_picture_book.php" method="POST">
                    <button type="submit" class="btn btn-danger">OK</button>
                    <input type="hidden" name="stored_picture_book_id" value="<?= $stored_picture_book['id'] ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
