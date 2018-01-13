<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;

                      @auth
                      @if(App\Platform::count())
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Платформы <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          @foreach(App\Platform::all() as $platform)
                            <li><a href="/games/{{ $platform->slug }}">{{ $platform->name }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                      @endif
                      @endauth

                      @auth
                      @if(App\Platform::count())
                      <li>
                       @if(App\Game::unapproved()->count())
                         <a href="/games/suggested">Предложенные <span class="badge">{{ App\Game::unapproved()->count() }}</span></a>
                       @endif
                      </li>
                      @endif
                      @endauth

                      @if(App\Platform::count())
                      <li><a href="/games/create">Предложить</a></li>
                      @endif

                      @if(App\Platform::count())
                      <li><a href="/list">Roll!</a></li>
                      @endif

                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                  @if(Auth::user()->inRole('invite-management'))
                                    <li>
                                      <a href="{{ route('invites.index') }}">Приглашения</a>
                                    </li>
                                  @endif

                                  @if(Auth::user()->inRole('user-management'))
                                    <li>
                                      <a href="{{ route('users.index') }}">Пользователи</a>
                                    </li>
                                  @endif

                                  @if(Auth::user()->inRole('platform-management'))
                                    <li>
                                      <a href="{{ route('platforms.index') }}">Платформы</a>
                                    </li>

                                    <li role="separator" class="divider"></li>
                                  @endif


                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
          @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
