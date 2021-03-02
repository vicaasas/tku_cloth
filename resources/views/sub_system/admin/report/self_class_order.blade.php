@extends('sub_system.layouts.base')
@section('title', '學生清單')
@section('content')
    <div class="container">
        <div id="app">
            {{ $class_order }}
        </div>
    </div>
@endsection
