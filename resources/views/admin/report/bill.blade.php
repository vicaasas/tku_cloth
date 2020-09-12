@extends('layouts.base')
@section('title', '繳費收據登記')
@section('content')
{{-- $class_name --}}
    <div class="container">
    <ul>
    
        @foreach($class_name as $class_name)
        <li>
            <a href="{{ route('print.class_bill',$class_name->class_name) }}">{{ $class_name->class_name }}</a>
        </li>
        @endforeach
    </ul>
    </div>

@endsection
