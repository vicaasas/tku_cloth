<div class="container">
    <div class="text-center h2">
        {{ substr(env('DB_DATABASE_SECOND'),0,3) }}學年度主畫面
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
                        <div style="float:left;">衣服領取時間</div>
                        
                        <table class="table table-sm table-striped table-hover table-condensed">
                        @foreach($get_cloth_time_list as $get_cloth_time_list)
                            <tr>
                                <th class="text-center align-middle">{{ $get_cloth_time_list->degree }}</th>
                                <th class="text-center align-middle">{{ $get_cloth_time_list->start_time }}</th>
                                <th class="text-center align-middle">{{ $get_cloth_time_list->end_time }}</th>
                            </tr>
                        @endforeach
                        </table>

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

                </div>
            </div>
        </div>
    </div>
</div>
