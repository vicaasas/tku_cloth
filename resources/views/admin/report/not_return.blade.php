@extends('layouts.base')
@section('title', '未歸還清單')
@section('content')

    <div class="container">
    <li>碩士</li>
    <ul>
    @foreach($m_n_return as $m_n_return)
        <li>{{ $m_n_return->class_name }} {{ $m_n_return->student_name }}</li>
    @endforeach
    </ul>
    <li>學士</li>
    <ul>
    
    @foreach($b_n_return as $b_n_return)
        <li>{{ $b_n_return->class_name }} {{ $b_n_return->student_name }}</li>
    @endforeach
    </ul>
    </div>
@endsection
