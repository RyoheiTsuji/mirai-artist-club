<!-- モーダルウィンドウの定義 -->
<div class="modal fade" id="artistSearchModal" tabindex="-1" aria-labelledby="artistSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="artistSearchModalLabel">作家を検索</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <!-- レベル -->
                    <div class="col-md-4">
                        <select id="level" class="form-select">
                            <option value="">レベルを選択</option>
                            <option value="1">レベル 1</option>
                            <option value="2">レベル 2</option>
                            <option value="3">レベル 3</option>
                        </select>
                    </div>
                    <!-- タグ -->
                    <div class="col-md-4">
                        <select id="tag" class="form-select">
                            <option value="">タグを選択</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- キーワード -->
                    <div class="col-md-4">
                        <input type="text" id="keyword" class="form-control" placeholder="キーワード検索">
                    </div>
                </div>
                <div class="text-end mb-3">
                    <button type="button" id="searchBtn" class="btn btn-primary">検索</button>
                </div>
                <div id="searchResults" class="d-flex flex-wrap justify-content-between">
                    <!-- 検索結果がここに表示される -->
                </div>
            </div>
        </div>
    </div>
</div>
