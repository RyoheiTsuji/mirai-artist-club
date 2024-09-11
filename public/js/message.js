$(document).ready(function() {
    // 検索ボタンがクリックされたときの処理
    $('#searchBtn').click(function() {
        var keyword = $('#keyword').val();
        var level = $('#level').val();
        var tag = $('#tag').val();

        // Ajaxリクエストで検索を実行
        $.ajax({
            url: '/admin/message/search', // Ajax検索のURL
            method: 'GET',
            data: {
                keyword: keyword,
                level: level,
                tag: tag
            },
            success: function(response) {
                // サーバーから返されたHTMLをモーダル内の #searchResults に挿入
                $('#searchResults').html(response.html);  // response.html からHTMLを表示
            },
            error: function(xhr) {
                console.error('検索エラー:', xhr);
            }
        });
    });

    // 検索結果から選択されたアーティストをメインフォームに追加
    $(document).on('change', '.artist-checkbox', function() {
        console.log('DOM is ready');
        var artistId = $(this).val();
        var artistName = $(this).data('name');

        if ($(this).is(':checked')) {
            // チェックされた場合、メインフォームに追加
            $('#recipient-list').append(`
            <div class="form-check" id="recipient-${artistId}">
                <input class="form-check-input artist-checkbox" type="checkbox" name="recipients[]" value="${artistId}" checked>
                <label class="form-check-label">${artistName}</label>
            </div>
        `);
        } else {
            // チェックが外れた場合、メインフォームから削除
            const element = $(`#recipient-${artistId}`);
            if (element.length) {
                console.log(`Removing element with id: recipient-${artistId}`);
                element.remove();
            } else {
                console.log(`Element with id: recipient-${artistId} not found`);
            }
        }
    });

});
