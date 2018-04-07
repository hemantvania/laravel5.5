@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1>View User</h1>
        <div class="row">
            <div class="col-lg-12">
                <h2>Add New User <span class="pull-right"><a href="{{ route('users') }}">Back</a></span> </h2>
                <form action="{{ route('addUser') }}" method="POST" class="form-group">
                    {{ csrf_field() }}
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Name</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Email</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Mobile</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Role</strong></li>
                        <li class="list-group-item col-xs-9">
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @if(!empty($roles))
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id  }}" @if($role->id == old('role') ) selected @endif >{{ $role->role  }}</option>
                                    @endforeach
                                @endif
                            </select> </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Password</strong></li>
                        <li class="list-group-item col-xs-9"><input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Occupassion</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="occupassion" name="occupassion" value="{{ old('occupassion') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>City</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>State</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="state" name="state" value="{{ old('state') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-3"><strong>Zip</strong></li>
                        <li class="list-group-item col-xs-9"><input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="form-control"></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item col-xs-12 text-center"><input class="btn btn-primary" type="submit" id="submit" name="submit" value="Submit"></li>
                    </ul>
                </form>
            </div>

            <div class="col-lg-6">
                
            </div>
        </div>
    </div>
@endsection
