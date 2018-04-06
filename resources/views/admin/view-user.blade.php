@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1>View User</h1>
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ $user->name }} <span class="pull-right"><a href="{{ url('admin/edit-user/userid/'.$user->id) }}">Edit</a></span> </h2>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Name</strong></li>
                    <li class="list-group-item col-xs-9">{{ $user->name }}</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Email</strong></li>
                    <li class="list-group-item col-xs-9">{{ $user->email }}</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Mobile</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->mobile_no){{ $user->mobile_no }} @else &nbsp; @endif</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Role</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->Role) {{ $user->Role->role }} @else &nbsp; @endif </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Occupassion</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->userDetails){{ $user->userDetails->occupassion }} @else &nbsp; @endif </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>City</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->userDetails){{ $user->userDetails->city }} @else &nbsp; @endif</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>State</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->userDetails){{ $user->userDetails->state }} @else &nbsp; @endif</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item col-xs-3"><strong>Zip</strong></li>
                    <li class="list-group-item col-xs-9">@if($user->userDetails){{ $user->userDetails->zip }} @else &nbsp; @endif</li>
                </ul>
            </div>
            <div class="col-lg-6">
                
            </div>
        </div>
    </div>
@endsection