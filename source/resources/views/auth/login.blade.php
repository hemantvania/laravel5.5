@extends('layouts.vdesk')

@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid login-contnet-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="login-section-title login-page">
                        <img src="{{ asset('img/student_login_head_logo.png') }}" alt="Teacher login" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="login-details-section">
                <div class="col-sm-4">
                    <div class="detail-box">
                        <p> @lang('login.welcome_desc') </p>
                    </div>
                </div>
                    <div class="col-sm-4">
                    <div class="login-box">
                        <h2>@lang('login.lable_title')</h2>
                        <div class="login-controls">
                            <form method="POST" action="{{ generateLangugeUrl(App::getLocale(),url('login')) }}">
                                {{ csrf_field() }}
                                @if(Session::has('error'))
                                    <div class="alert {{ Session::get('class') }} alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <div class="login-controls--group has-error">
                                        <span class="help-block">
                                            <strong>@lang('login.login_message')</strong>
                                        </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="login-controls--group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>@lang('login.field_user')</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required />

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="login-controls--group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>@lang('login.field_password')</label>
                                <input id="password" type="password"  name="password" required />
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>@lang('login.login_pass_mesasge')</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="login-controls--forgotPW">
                                <a href="{{ route('OtherLogin') }}">@lang('login.lable_teacher')</a> |
                                <a href="{{ route('password.request') }}">@lang('login.lable_forgetpass')</a>
                            </div>
                                <div class="text-right">
                                <button type="submit" class="btn btn-secondary">@lang('login.lable_login_btn')</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-4 cust_right_login">
                        <img src="{{ asset('img/student_login_middle_right.png') }}" alt="student_login_middle_right" class="img-responsive" />
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script type="text/javascript">
    jQuery(function(){
        jQuery('#email').focus();
    })
    </script>
@endsection