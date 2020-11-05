@extends('layouts.base')
@section('title', '退款')
@section('content')
{{-- $class_name --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        退款
                    </div>
                    <div class="card-body">
                        <form action="{{ route('return.get_refund_order') }}" method="get">
                            @csrf
                            <div class="form-group row">
                                <label id="title_name" for="get_id" class="col-md-4 col-form-label text-md-right">
                                    學號/訂單編號
                                </label>

                                <div class="col-md-6">
                                    <input id="get_id" type="text"
                                           class="form-control"
                                           name="get_id" required autocomplete="on" autofocus>
    
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        搜尋
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="show">
                    @if(isset($student_table))
                        {!! $student_table !!}
                    @endif
                    @if(isset($order_list))
                        {{ $order_list }}
                    @endif
                </div>
            </div>
           
        </div>
    </div>

@endsection
