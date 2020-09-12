@extends('layouts.base')
@section('title', '系統設定')
@section('content')
    <div class="container">
        <div class="h2 text-center">
            系統設定
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-header">
                        新增學生
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('system.new_user') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="stu_id" class="col-md-4 col-form-label text-md-right">
                                    學號
                                </label>

                                <div class="col-md-6">
                                    <input id="stu_id" type="text"
                                           class="form-control @error('stu_id') is-invalid @enderror"
                                           name="stu_id" required autocomplete="stu_id">

                                    @error('stu_id')
                                    <span class="invalid-feedback"
                                          role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <span class="text-muted offset-md-4 col-md-8">
                                        學生預設密碼為學號後 6 碼
                                    </span>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    姓名
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('class') is-invalid @enderror"
                                           name="name" required autocomplete="name">

                                    @error('class')
                                    <span class="invalid-feedback"
                                          role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">學制</label>
                                <div class="col-md-6">
                                    <select id="department" class="form-control" name="department">
                                        <option>{{ \App\User::DEPARTMENT_BACHELOR }}</option>
                                        <option>{{ \App\User::DEPARTMENT_MASTER }}</option>
                                        <option>{{ \App\User::DEPARTMENT_DOCTOR }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="class" class="col-md-4 col-form-label text-md-right">
                                    系級
                                </label>

                                <div class="col-md-6">
                                    <input id="class" type="text"
                                           class="form-control @error('class') is-invalid @enderror"
                                           name="class" required autocomplete="class">

                                    @error('class')
                                    <span class="invalid-feedback"
                                          role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        新增學生
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        新增管理員
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('system.new_user') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">
                                    使用者帳號
                                </label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           name="username" required autocomplete="username">

                                    @error('username')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">
                                    使用者密碼
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">
                                    確認密碼
                                </label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           name="password_confirmation" required autocomplete="password_confirmation">

                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        新增管理員
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card mb-3">
                    <div class="card-header">
                        匯入學生資料
                    </div>
                    <div class="card-body">
                        <form method="post"  enctype="multipart/form-data" action="{{ route('system.import_students') }}">
                            @csrf
                            <input type="file" name="csv_file" id="csv_file" class="form-control-file @error('csv_file') is-invalid @enderror">
                            @error('csv_file')
                            <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            <button type="submit" class="btn btn-danger">
                                確定
                            </button>
    
                        </form>
                    </div>
                </div>
                <div class="card border-danger mb-3">
                    <div class="card-header">
                        刪除學生資料
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            將會把所有學生從資料庫清除且<span class="text-danger">不可復原</span><br>
                            同時也會將所有訂單資料清除且<span class="text-danger">不可復原</span>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#clearStudents">
                            是的，我要刪除！
                        </button>
                        <div class="modal fade" id="clearStudents" data-backdrop="static" tabindex="-1" role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            刪除所有學生資料
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="{{ route('system.drop_students') }}">
                                        @csrf

                                        <div class="modal-body">
                                            你確定要刪除所有學生資料嗎？<span class="text-danger">（此動作不可復原）</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">
                                                取消
                                            </button>
                                            <button type="submit" class="btn btn-danger">
                                                確定
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection