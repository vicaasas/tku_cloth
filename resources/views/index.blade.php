@extends('layouts.base')
@section('title', '首頁')
@section('content')
    @can('admin')
        @include('admin.index')
    @elsecan('student')
        @include('student.index')
    @endcan
@endsection
