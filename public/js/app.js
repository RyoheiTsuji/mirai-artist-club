$(document).ready(function () {
    // 初期選択された作家を表示
    updateSelectedArtists();

    $('#searchButton').on('click', function (e) {
        e.preventDefault();
        let url = '/admin/offer/search-artists'; // ルートをここで指定

        // 各フィールドの値を取得
        let formData = {
            level: $('#level').val(),
            tag: $('#tag').val(),
            keyword: $('#keyword').val()
        };

        // デバッグ用にデータをコンソールに出力
        console.log('送信するデータ:', formData);

        // AJAXリクエスト
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                let resultsContainer = $('#searchResults');
                resultsContainer.empty();

                if (data.artists && data.artists.length > 0) {
                    data.artists.forEach(function (artist) {
                        const isChecked = selectedArtists[artist.id] ? 'checked' : '';

                        let tagsHtml = '';
                        artist.tag_names.forEach(function (tag) {
                            tagsHtml += `<span class="tag-label">${tag}</span> `;
                        });

                        let levelClass = 'level-' + artist.level;

                        let listItem = `
                                <li class="list-group-item d-flex flex-column col-md-3 ${levelClass}">
                                    <div class="p-1 m-1 ${levelClass}">
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="checkbox" name="selected_artists[]" value="${artist.id}" class="artist-checkbox" ${isChecked}>
                                        </div>
                                        <div class="col">
                                            <div class="artist-info">
                                                <div class="artist-name-level mb-1">
                                                    ${artist.name} (レベル: ${artist.level})
                                                </div>
                                                <div class="artist-tags">
                                                    ${tagsHtml}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>`;
                        resultsContainer.append(listItem);
                    });

                    // チェックボックスが選択されたときの処理
                    $('.artist-checkbox').off('change').on('change', function () {
                        const artistId = $(this).val();
                        if ($(this).prop('checked')) {
                            const artistName = $(this).closest('li').find('.artist-name-level').text();
                            const artistTags = $(this).closest('li').find('.artist-tags').html();
                            const artistLevel = $(this).closest('li').find('.artist-name-level').text().match(/\(レベル: (\d+)\)/)[1];
                            selectedArtists[artistId] = {
                                name: artistName,
                                tags: artistTags,
                                levelClass: 'level-' + artistLevel
                            };
                        } else {
                            delete selectedArtists[artistId];
                        }
                        updateSelectedArtists();
                    });
                } else {
                    resultsContainer.append('<li class="list-group-item">該当する作家がいません。</li>');
                }
            },
            error: function (xhr, status, error) {
                console.error('エラーが発生しました:', error);
                console.error('ステータス:', status);
                console.error('サーバーレスポンス:', xhr.responseText);
            }
        });
    });

    // 選択された作家リストを更新する関数
    function updateSelectedArtists() {
        const selectedArtistsContainer = $('#selectedArtists');
        selectedArtistsContainer.empty(); // 既存の表示をクリア

        if (Object.keys(selectedArtists).length === 0) {
            selectedArtistsContainer.append(`
                    <li class="list-group-item text-center">案件送付先の作家が選択されていません。</li>
                `);
        } else {
            $.each(selectedArtists, function (artistId, artistData) {
                selectedArtistsContainer.append(`
                        <li class="list-group-item d-flex flex-column col-md-3">
                            <div class="${artistData.levelClass} m-1 p-1 w-100">
                                <div class="d-flex align-items-center mb-2">
                                    ${artistData.name}
                                </div>
                                <div class="col">
                                    <div class="artist-tags">
                                        ${artistData.tags}
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm ms-auto remove-artist" data-id="${artistId}">削除</button>
                                <input type="hidden" name="selected_artists[]" value="${artistId}">
                            </div>
                        </li>
                    `);
            });

            // 削除ボタンの処理
            $('.remove-artist').off('click').on('click', function () {
                const artistId = $(this).data('id');
                delete selectedArtists[artistId]; // オブジェクトから削除
                $(`.artist-checkbox[value="${artistId}"]`).prop('checked', false); // チェックを外す
                updateSelectedArtists(); // リストを更新
            });
        }
    }
});
