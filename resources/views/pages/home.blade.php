
        @extends('layouts.default')
        @section('content')   
           <div class="content">
               <div class="container">
                   @foreach ($users as $user)
                       {{ $user->name }}
                   @endforeach
               </div>
                       {{ $users->links() }}
               {{ $users->appends(['sort' => 'role'])->links() }}
               {{ $users->fragment('role')->links() }}
                           <div class="links">
                               <a href="https://laravel.com/docs">Documentation</a>
                               <a href="https://laracasts.com">Laracasts</a>
                               <a href="https://laravel-news.com">News</a>
                               <a href="https://forge.laravel.com">Forge</a>
                               <a href="https://github.com/laravel/laravel">GitHub</a>
                           </div>
                       </div>
                   @stop

