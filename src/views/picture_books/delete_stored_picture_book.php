<!-- bookshelf.php で使用 -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-danger bg-white text-danger btn-sm" data-toggle="modal" data-target="#deleteId<?= $display_read_record['id'] ?>" title="絵本を本棚から削除する"><i class="far fa-trash-alt"></i></button>
<!-- Modal -->
<div class="modal fade" id="deleteId<?= $display_read_record['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteIdLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteIdLabel">削除の確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                『<?= $display_read_record['title'] ?>』を本棚から削除してもよろしいですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <form action="../picture_books/delete_stored_picture_book.php" method="POST">
                    <button type="submit" class="btn btn-danger">OK</button>
                    <input type="hidden" name="stored_picture_book_id" value="<?= $display_read_record['id'] ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
