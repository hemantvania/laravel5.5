@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1>View User</h1>
        <div class="row">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ $message }}</strong>

                </div>

            @endif
                @if ($message = Session::get('error'))

                    <div class="alert alert-danger alert-block">

                        <button type="button" class="close" data-dismiss="alert">×</button>

                        <strong>{{ $message }}</strong>

                    </div>

                @endif
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
                <ul class="list-group">
                    <li class="list-group-item col-xs-12"><a id="deleteUser" href="{{ url('admin/delete-user/userid/'. $user->id) }}" class="btn btn-danger pull-right">Delete User</a> </li>
                </ul>
            </div>
            <div class="col-lg-6">
                
            </div>
        </div>
    </div>
@endsection