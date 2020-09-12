@extends('layouts.base')
@section('title', '學生清單')
@section('content')
    <div class="container">
        <div id="app">
        <table>
            <thead>
                <tr id='column_name'>
                <th class="text-center align-middle">學號</th>
                <th class="text-center align-middle">姓名</th>
                <th class="text-center align-middle">衣服尺寸</th>
                <th class="text-center align-middle">配件顏色</th>
                <th class="text-center align-middle">訂單狀態</th>
                </tr>
            </thead>
            <tbody>
            @foreach($class_order as $class_order)
            <tr>
            <th>{{ $class_order->student_id }}</th>
            <th>{{ $class_order->student_name }}</th>
            @if($class_order->size != null)
                <th>{{ $class_order->size }}</th>
            @else
                <th>未訂購</th>
            @endif

            @if($class_order->size != null)
                <th>{{ $class_order->color }}</th>
            @else
                <th>未訂購</th>
            @endif
            <th>{{ $class_order->state }}</th>
            </tr>
            
            @endforeach
            </tbody>
            
        </table>
        </div>
    </div>
@endsection