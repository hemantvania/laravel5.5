@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="title">Users</div>
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
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile_no }}</td>
                <td>
                    @if($user->userDetails)
                    {{ $user->userDetails->occupassion }}
                    @endif
                </td>
                <td>
                    @if($user->userDetails)
                    {{ $user->userDetails->city }}
                    @endif
                </td>
                <td>
                    @if($user->userDetails){{ $user->userDetails->state }} @endif </td>
                <td>@if($user->userDetails) {{ $user->userDetails->zip }} @endif </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection