<div class="flex-center position-ref">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
                <a href="{{ url('/admin/users') }}">Users</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
    @endif

</div>