@extends('layouts.base')
@section('title', '首頁')
@section('content')
    @if(Gate::check('admin') || Gate::check('sub_admin') || Gate::check('give_cloth_people'))
        @include('admin.index')
    @elseif(Gate::check('student'))
        @include('student.index')
    @endif
@endsection
