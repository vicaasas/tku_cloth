@extends('layouts.base')
@section('title', '時間段管理')
@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header text-center">
                時間管理
            </div>
            <div class="card-body text-right">
                <div class="container-fluid">
                    <table class="table table-sm table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th class="text-center align-middle"><strong>時間段</strong></th>
                            <th class="text-center align-middle"><strong>開始時間</strong></th>
                            <th class="text-center align-middle"><strong>結束時間</strong></th>
                            <th class="text-center align-middle"><strong>操作</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($time_list as $key => $data)
                            <tr>
                                <th class="text-center align-middle">{{ $data->content }}</th>
                                <th class="text-center align-middle">{{ $data->start_time }}</th>
                                <th class="text-center align-middle">{{ $data->end_time }}</th>
                                <th class="text-center align-middle">
                                    <div class="btn-group" role="group" aria-label="Operation Column">
                                        <button type="button" class="btn btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $data->id }}">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                 class="bi bi-pencil-square"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $data->id }}">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                        <div class="modal fade" id="edit{{ $data->id }}" data-backdrop="static"
                                             tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            編輯 {{ $data->content }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post"
                                                          action="{{ route('time.update', ['time'=>$data->id]) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="start_time">開始時間</label>
                                                                <input type="date"
                                                                       class="form-control @error('start_time') is-invalid @enderror"
                                                                       id="start_time"
                                                                       name="start_time"
                                                                       value="{{ $data->start_time }}">

                                                                @error('start_time')
                                                                <span class="invalid-feedback"
                                                                      role="alert"><strong>{{ $message }}</strong></span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="end_time">結束時間</label>
                                                                <input type="date"
                                                                       class="form-control @error('end_time') is-invalid @enderror"
                                                                       id="end_time"
                                                                       name="end_time"
                                                                       value="{{ $data->end_time }}">

                                                                @error('end_time')
                                                                <span class="invalid-feedback"
                                                                      role="alert"><strong>{{ $message }}</strong></span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                關閉
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                送出
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="delete{{ $data->id }}" data-backdrop="static"
                                             tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            刪除 {{ $data->content }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post"
                                                          action="{{ route('time.destroy', ['time'=>$data->id]) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-body">
                                                            你確定要刪除 {{ $data->content }} 嗎？（此動作不可復原）
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
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addNewData">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h5v-1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5v2.5A1.5 1.5 0 0 0 10.5 6H13v2h1V6L9 1z"/>
                            <path fill-rule="evenodd"
                                  d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                            <path fill-rule="evenodd"
                                  d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                        </svg>
                        新增時間段
                    </button>
                    <div class="modal fade text-center" id="addNewData" data-backdrop="static" tabindex="-1"
                         role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        新增資料
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('time.store') }}">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="content">時間段名稱</label>
                                            <input type="text"
                                                   class="form-control @error('content') is-invalid @enderror"
                                                   id="content" name="content">

                                            @error('content')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="start_time">開始時間</label>
                                            <input type="date"
                                                   class="form-control @error('start_time') is-invalid @enderror"
                                                   id="start_time" name="start_time">

                                            @error('start_time')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="end_time">結束時間</label>
                                            <input type="date"
                                                   class="form-control @error('end_time') is-invalid @enderror"
                                                   id="end_time" name="end_time">

                                            @error('end_time')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            取消
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            新增資料
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
@endsection