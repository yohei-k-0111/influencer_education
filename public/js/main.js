// function setMethod(method) {
//     document.getElementById('form_method').value = method;
// }

// profile_edit.blade.phpのフラッシュメッセージ処理
$(document).ready(function() {
    // Toastrのオプションを設定
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "2000", // 2秒間表示
        "extendedTimeOut": "1000"
    };

    // フラッシュメッセージがある場合にToastrを表示
    function showToastrMessages() {
        const successMessage = $('meta[name="success-message"]').attr('content');
        const errorMessage = $('meta[name="error-message"]').attr('content');

        if (successMessage) {
            toastr.success(successMessage);
        }

        if (errorMessage) {
            toastr.error(errorMessage);
        }
    }

    showToastrMessages();
});

// 削除機能の非同期処理
$(function() {
    $('.delete-btn').on('click', function(event) {
        // HTMLでの送信をキャンセル
        event.preventDefault();
        const deleteConfirm = confirm('削除してよろしいでしょうか？');
        if(deleteConfirm) {
            const articleID = $(this).data('article_id');
            const url = $(this).data('url');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                // const productID = $(this).data('product_id');
                type: 'POST',
                url: url,
                data: {'article_id': articleID, '_method': 'DELETE'} // DELETE リクエストだよ！と教えてあげる。
            })

            .done(function(response) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "2000", // 2秒間表示
                    "extendedTimeOut": "1000"
                };
                toastr.success(response.success);
                setTimeout(function() {
                    location.reload();
                }, 2000); // 2秒後にリロード
            })
            .fail(function(xhr) {
                if (xhr.status === 404){
                    toastr.error('投稿が見つかりませんでした。');
                } else {
                    toastr.error('削除できませんでした。');
                }
            });
        }
    });
});