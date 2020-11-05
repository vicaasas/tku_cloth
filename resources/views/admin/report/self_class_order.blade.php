@extends('layouts.base')
@section('title', '班級訂單')
@section('content')
    <div class="container">
        <div id="app">
            {{ $class_order }}
        </div>
    </div>
@endsection