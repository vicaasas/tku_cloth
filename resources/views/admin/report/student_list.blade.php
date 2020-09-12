@extends('layouts.base')
@section('title', '學生清單')
@section('content')
    <div class="container">
        <div id="app">

            <Student_order_table :student_order="{{ $all_student_order }}"></Student_order_table>

        </div>
    </div>

    <script src="{{ asset('js/order_table.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
