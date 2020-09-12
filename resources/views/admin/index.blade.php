<div class="container">
    <div class="text-center h2">
        主畫面
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    時間設定
                </div>
                <div class="card-body text-right">
                    <div class="container-fluid">
                        <table class="table table-sm table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th class="text-center align-middle"><strong>時間段</strong></th>
                                <th class="text-center align-middle"><strong>開始時間</strong></th>
                                <th class="text-center align-middle"><strong>結束時間</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($time_list as $key => $data)
                                <tr>
                                    <th class="text-center align-middle">{{ $data->content }}</th>
                                    <th class="text-center align-middle">{{ $data->start_time }}</th>
                                    <th class="text-center align-middle">{{ $data->end_time }}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('time.index') }}" class="btn btn-primary">
                            管理時間段
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                                <path fill-rule="evenodd"
                                      d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header text-center">
                    歸還地點設定
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('update.location') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">
                                歸還地點
                            </label>

                            <div class="col-md-6">
                                <input id="location" type="text" value="{{ $location }}"
                                       class="form-control @error('location') is-invalid @enderror"
                                       name="location" required autocomplete="location">

                                @error('location')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    更新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    物品數量設定
                </div>
                <div class="card-body text-right">
                    <table class="table table-sm table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th class="text-center align-middle"><strong>學制</strong></th>
                            <th class="text-center align-middle"><strong>服裝 / 配件</strong></th>
                            <th class="text-center align-middle"><strong>尺寸 / 顏色</strong></th>
                            <th class="text-center align-middle"><strong>總計數量</strong></th>
                            <th class="text-center align-middle"><strong>剩餘數量</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $cloth_table !!}
                        </tbody>
                    </table>
                    <a href="{{ route('cloth.index') }}" class="btn btn-primary">
                        管理物品數量
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                            <path fill-rule="evenodd"
                                  d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
