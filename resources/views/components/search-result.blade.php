
    @foreach ($artists as $artist)
        <div class="form-check mb-3" style="width: 32%; padding-left:0;">
            <!-- 全体をラベルとしてまとめる -->
            <label class="form-check-label d-flex align-items-center badge bg-primary text-wrap p-3" for="artist{{ $artist->id }}" style="width: 100%;">
                <!-- チェックボックス -->
                <input class="form-check-input me-2 artist-checkbox" style="margin-left:-0.5rem" type="checkbox" value="{{ $artist->id }}" data-name="{{ $artist->name }}" id="artist{{ $artist->id }}">

                <!-- 名前とレベル部分 -->
                <div class="d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between text-white">
                        <strong>{{ $artist->name }}</strong> (レベル: {{ $artist->level }})
                    </div>

                    <!-- タグ部分 -->
                    <div class="mt-2">
                        @foreach ($artist->tags as $tag)
                            <span class="me-1 mb-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </label>
        </div>
    @endforeach

<!-- スタイルの追加 -->
<style>
    #searchResults {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .form-check {
        margin-bottom: 15px;
    }

    .form-check .badge {
        margin-top: 5px;
    }
</style>
