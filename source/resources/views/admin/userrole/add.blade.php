@extends("admin.layout.default")

@if(isset($getRecords))
    @if($getRecords->rolename )
        @section('title',$getRecords->rolename)
    @else
        @section('title', __('adminuserrole.title'))
    @endif
@else
    @section('title', __('adminuserrole.title'))
@endif


@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('adminuserrole.title')
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <!-- right column -->
                <div class="col-md-6">

                    <!-- general form elements disabled -->
                    <div class="box box-warning">

                        <div class="box-header with-border">
                            <h3 class="box-title">
                                    @if(isset($getRecords))
                                        @if($getRecords->rolename )
                                            {{$getRecords->rolename }}
                                        @endif
                                    @else
                                        @lang('adminuserrole.adduserrole')
                                     @endif
                            </h3>
                        </div>
                        @if(isset($getRecords))
                            <form role="form" action="{{ url('admin/userrole/'.$getRecords->id.'/edit') }} " method="post">
                        @else
                            <form role="form" action="{{ url('admin/userrole/add') }} " method="post">
                        @endif
                        <!-- /.box-header -->

                        <div class="box-body">


                            {{ csrf_field() }}

                                <!-- text input -->
                                <div class="form-group {{ $errors->has('rolename') ? ' has-error' : '' }}">

                                    <label>@lang('adminuserrole.rolename')<em>*</em></label>

                                    <input type="text" class="form-control" value="@if(isset($getRecords->rolename)){{$getRecords->rolename}} @else {{ old('rolename') }} @endif" name="rolename" placeholder="@lang('adminuserrole.rolename')">
                                    @if ($errors->has('rolename'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rolename') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <!-- select -->
                                <div class="form-group {{ $errors->has('isactive') ? ' has-error' : '' }}">

                                    <label>@lang('adminuserrole.status')<em>*</em></label>

                                    <select class="form-control" name="isactive">
                                        <option value="">@lang('adminuserrole.selectstatus')</option>
                                        <option value="1" @if(isset($getRecords->isactive)){{ $getRecords->isactive === 1 ? "selected" : "" }} @endif>@lang('adminuserrole.active')</option>
                                        <option value="0" @if(isset($getRecords->isactive)){{ $getRecords->isactive === 0 ? "selected" : "" }} @endif>@lang('adminuserrole.deactive')</option>
                                    </select>

                                    @if ($errors->has('isactive'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('isactive') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- select -->
                                <div class="form-group {{ $errors->has('countries') ? ' has-error' : '' }}">

                                    <label>@lang('adminuserrole.countries')<em>*</em></label>

                                    <select class="form-control" name="countries[]" multiple="multiple">
                                        @if(!empty($countrieList))
                                            @foreach($countrieList as $country)
                                                <option value="{{$country->id}}" @if(!empty($countriesListEdit) && in_array($country->countryname,$countriesListEdit)) selected="selected" @endif>{{$country->countryname}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('countries'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('countries') }}</strong>
                                        </span>
                                    @endif
                                </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="@if(isset($getRecords)) @lang('adminuserrole.update') @else @lang('adminuserrole.add') @endif" name="submit">

                            <a href="{{ url('admin/userrole') }}" class="btn btn-default">@lang('general.cancel')</a>
                        </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")
    <script src="{{ asset('assests/admin/userrole/userrole.js') }}"></script>
@endsection