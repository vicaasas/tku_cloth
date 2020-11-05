@extends('sub_system.layouts.base')
@section('title', '首頁')
@section('content')
    @can('admin')
        @include('sub_system.admin.index')
    @elsecan('student')
        @include('sub_system.student.index')
    @endcan
@endsection
