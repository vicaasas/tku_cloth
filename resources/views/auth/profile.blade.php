@extends('layouts.base')
@section('title', '個人設定')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        密碼變更
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.change.password') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="user_old_password" class="col-md-4 col-form-label text-md-right">
                                    舊密碼
                                </label>

                                <div class="col-md-6">
                                    <input id="user_old_password" type="password"
                                           class="form-control @error('user_old_password') is-invalid @enderror"
                                           name="user_old_password" required autocomplete="user_old_password" autofocus>

                                    @error('user_old_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">
                                    新密碼
                                </label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password"
                                           class="form-control @error('new_password') is-invalid @enderror"
                                           name="new_password" required autocomplete="new_password" autofocus>

                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">
                                    確認新密碼
                                </label>

                                <div class="col-md-6">
                                    <input id="new_password_confirmation" type="password"
                                           class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                           name="new_password_confirmation" required
                                           autocomplete="new_password_confirmation" autofocus>

                                    @error('new_password_confirmation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        送出
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @can('admin')
                    <div class="card mb-3">
                        <div class="card-header">
                            經手人印鑑圖檔
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.change.image') }}"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4 text-md-right">
                                        現有圖片
                                    </div>
                                    <div class="col-md-6">
                                        <img src="data:image/jpeg;base64,{{ Auth::user()->base64Img }}" alt="未設定圖檔">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="image" class="col-md-4 col-form-label text-md-right">
                                        更新圖檔
                                    </label>
                                    <div class="col-md-6 custom-file">
                                        <input id="image" type="file" accept="image/*" name="image"
                                               class="form-control-file @error('image') is-invalid @enderror">
                                        @error('image')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            上傳圖檔
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
