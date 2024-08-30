$(document).ready(function () {
    $('body').on('click', '.clear', function (e) {
        // ボタンがdisabledされていたら、何もせず処理を中断する
        if ($(this).prop('disabled')) {
            return;
        }

        e.preventDefault();

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var userId = YOUR_USER_ID;
        var curriculumId = YOUR_CURRICULUM_ID; // Ensure this is set correctly

        console.log('User ID:', userId);
        console.log('Curriculum ID:', curriculumId); // Debug log

        if (confirm("本当に受講を完了してもよろしいですか？")) {
            $.ajax({
                url: CLEAR_ROUTE_URL,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    user_id: userId,
                    curriculum_id: curriculumId
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message || '受講の完了に失敗しました。');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        var errors = jqXHR.responseJSON.errors;
                        var errorMessage = 'バリデーションエラーが発生しました:\n';
                        $.each(errors, function (key, value) {
                            errorMessage += value + '\n';
                        });
                        alert(errorMessage);
                    } else {
                        console.error('Error completing curriculum:', errorThrown);
                        alert('受講の完了中にエラーが発生しました: ' + errorThrown);
                    }
                }
            });
        }
    });
});
