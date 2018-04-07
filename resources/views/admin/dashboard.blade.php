@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1>HI {{ Auth::user()->name }}, Welcome to Admin</h1>
        <div class="row">
            <div class="col-lg-6">
                <h2>Users <span class="pull-right">( Total: {{ $TotalUsers }} )</span></h2>
                <ul class="list-group">
                    <li class="list-group-item col-xs-6"><strong>Name</strong></li>
                    <li class="list-group-item col-xs-6"><strong>Email</strong></li>
                </ul>
                <ul class="list-group">
                    @foreach($users as $user)
                    <li class="list-group-item col-xs-6">{{ $user->name }}</li>
                        <li class="list-group-item col-xs-6">{{ $user->email }}</li>
                    @endforeach
                    @if($users->count() < $TotalUsers )
                    <li class="list-group-item col-xs-12 text-center"><a href="{{ url('admin/users') }}"> View All</a></li>
                    @endif
                </ul>
            </div>
            <div class="col-lg-6">

            </div>
        </div>
    </div>
@endsection