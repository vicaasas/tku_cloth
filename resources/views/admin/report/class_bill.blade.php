@extends('layouts.base')
@section('title', '班級帳單')
@section('content')

    <div class="container">
    <h1>{{ $class_name }} 的帳單</h1>
        收到收據時間：
        <input type="date" name="" id="">
        <button onclick="window.open('{{ route('print.class_bill_pdf',$class_name) }}')">列印班級繳費單</button>
        <button>重設{{ $class_name }}繳費單列印狀態</button>
    </div>

@endsection
