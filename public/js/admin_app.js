$(document).ready(function() {
    // 初期設定: アイコンの回転アニメーションを500msに設定
    $('#toggle_hint i').css('transition', 'transform 500ms ease');

    // ロード完了後250ms後にアイコンを回転させる
    setTimeout(function() {
        $('#toggle_hint i').css('transform', 'rotate(-90deg)'); // アイコンを180度回転させる
    }, 250); // 250ms後に回転開始

    // アイコンが回転し終わったら250ms待機してからウィンドウをスライドアウト
    setTimeout(function() {
        $('#hints_window').css('right', '-300px');
    }, 1000); // 250ms (待機) + 500ms (回転) + 250ms (待機) = 1000ms後にスライドアウト開始

    $('#toggle_hint').on('click', function() {
        var $hintsWindow = $('#hints_window');
        var $icon = $('#toggle_hint i');
        if ($hintsWindow.css('right') === '-300px') {
            // 画面にスライドインする
            $hintsWindow.css('right', '0');
            $icon.css('transform', 'rotate(90deg)'); // アイコンを元に戻す
        } else {
            // 画面外にスライドアウトする
            $hintsWindow.css('right', '-300px');
            $icon.css('transform', 'rotate(-90deg)'); // アイコンを再度回転させる
        }
    });

    // 通知アイコンをクリックしたとき
    $('#notification-icon').on('click', function(event) {
        event.preventDefault(); // デフォルトのリンク動作を無効化
        $('#notifications-dropdown').toggle(); // ドロップダウンメニューの表示・非表示を切り替え
    });

    // ページ内の他の場所をクリックしたときにドロップダウンを閉じる
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#notification-icon').length && !$(event.target).closest('#notifications-dropdown').length) {
            $('#notifications-dropdown').hide();
        }
    });

    // ヒント機能を初期化
    initializeHints('#hints_window .hint_article', '[id]');
});

function initializeHints(hintsSelector, triggerSelector) { //管理画面全体のヒント機能
    // 指定された要素にホバーイベントを設定
    $(triggerSelector).hover(
        function() {
            var targetId = $(this).attr('id');
            // 全てのhint_articleを非表示にする
            $(hintsSelector).hide();
            // 対応するhint_articleのみ表示する
            $(hintsSelector + '[data-target="' + targetId + '"]').show();
        },
        function() {
            // ホバー解除時にすべてのhint_articleを非表示にする
            $(hintsSelector).hide();
        }
    );
}
