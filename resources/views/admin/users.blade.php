@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="title">Users</div>
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
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Occupassion</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td><a href="{{ url('admin/view-user/userid/'.$user->id) }}" title="View User Details">{{ $user->email }}</a></td>
                <td>{{ $user->mobile_no }}</td>
                <td>@if($user->userDetails) {{ $user->userDetails->occupassion }} @endif </td>
                <td>@if($user->userDetails) {{ $user->userDetails->city }} @endif </td>
                <td>@if($user->userDetails){{ $user->userDetails->state }} @endif </td>
                <td>@if($user->userDetails) {{ $user->userDetails->zip }} @endif </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="7"><a href="{{ route('addNewUser') }}" class="btn btn-primary pull-right" >Add New User</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection