@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Users</div>

                <div class="card-body">
                    <users-list :users="{{ $users }}"></users-list>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/datatable.js') }}"></script>
@endsection


