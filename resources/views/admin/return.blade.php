@extends('layouts.base')
@section('title', '物品歸還')
@section('nav_return', 'active')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        物品歸還
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('cloths.get_student_order') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="stu_id" class="col-md-4 col-form-label text-md-right">
                                    學號
                                </label>

                                <div class="col-md-6">
                                    <input id="stu_id" type="text"
                                           class="form-control @error('stu_id') is-invalid @enderror"
                                           name="stu_id" required autocomplete="stu_id" autofocus>

                                    @error('stu_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
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
            </div>
        </div>
        <div>
        @if(isset($this_student_order))

        {{$this_student_order}}
            
        @endif
        </div>
    </div>
@endsection
