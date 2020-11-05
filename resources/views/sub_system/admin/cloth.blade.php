@extends('layouts.base')
@section('title', '物品數量管理')
@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header text-center">
                物品數量管理
            </div>
            <div class="card-body text-right">
                <div class="container-fluid">
                    <table class="table table-sm table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th class="text-center align-middle"><strong>服裝 / 配件</strong></th>
                            <th class="text-center align-middle"><strong>尺寸 / 顏色</strong></th>
                            <th class="text-center align-middle"><strong>總計數量</strong></th>
                            <th class="text-center align-middle"><strong>剩餘數量</strong></th>
                            <th class="text-center align-middle"><strong>操作</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cloths as $data)
                            <tr>
                                <th class="text-center align-middle">{{ $data->type . $data->name }}</th>
                                <th class="text-center align-middle">{{ $data->property }}</th>
                                <th class="text-center align-middle">{{ $data->quantity }}</th>
                                <th class="text-center align-middle">
                                    {{ $data->quantity - count($orders->where('cloth', $data->id)->where('state', !App\Order::STATE_RETURNED)) - count($orders->where('accessory', $data->id)->where('state', !App\Order::STATE_RETURNED)) }}
                                </th>
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
                                                            編輯 {{ $data->type . $data->name . $data->property }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post"
                                                          action="{{ route('cloth.update', ['cloth'=>$data->id]) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-4 text-right">
                                                                    物品：
                                                                </div>
                                                                <div class="col-md-8 text-left">
                                                                    {{ $data->type . $data->name }}
                                                                </div>
                                                                <div class="col-md-4 text-right">
                                                                    尺寸 / 顏色：
                                                                </div>
                                                                <div class="col-md-8 text-left">
                                                                    {{ $data->property }}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label for="quantity"
                                                                       class="col-md-4 text-right">數量：</label>
                                                                <input type="text"
                                                                       class="form-control col-md-8 text-left @error('quantity') is-invalid @enderror"
                                                                       id="quantity"
                                                                       name="quantity"
                                                                       value="{{ $data->quantity }}">

                                                                @error('quantity')
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
                                                            刪除 {{ $data->type . $data->name . $data->property }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post"
                                                          action="{{ route('cloth.destroy', ['cloth'=>$data->id]) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-body">
                                                            你確定要刪除 {{ $data->type . $data->name . $data->property }}
                                                            嗎？（此動作不可復原）
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
                        新增物品種類
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
                                <form method="post" action="{{ route('cloth.store') }}">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="type">學制</label>
                                            <select id="type" class="form-control" name="type">
                                                <option>{{ \App\User::DEPARTMENT_BACHELOR }}</option>
                                                <option>{{ \App\User::DEPARTMENT_MASTER }}</option>
                                                <option>{{ \App\User::DEPARTMENT_DOCTOR }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">物品名稱</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name">

                                            @error('name')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="property">尺寸 / 顏色</label>
                                            <input type="text"
                                                   class="form-control @error('property') is-invalid @enderror"
                                                   id="property" name="property">

                                            @error('property')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">數量</label>
                                            <input type="text"
                                                   class="form-control @error('quantity') is-invalid @enderror"
                                                   id="quantity" name="quantity">

                                            @error('quantity')
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