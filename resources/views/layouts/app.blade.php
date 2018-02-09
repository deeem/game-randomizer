<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

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
                      <img src="{{ asset('/img/gamepad.svg') }}" alt="Brand">
                      <p>{{ config('app.name', 'Laravel') }}</p>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;

                      @if(App\Platform::count())
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Добавленные игры <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          @foreach(App\Platform::all() as $platform)
                            <li><a href="/games/{{ $platform->slug }}">{{ $platform->name }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                      @endif

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
                      <li><a href="/games/suggest">Предложить</a></li>
                      @endif

                      @if(App\Platform::count())
                      <li class="randomize">
                        <a href="/list">
                          <img src="{{ asset('img/perspective-dice-six-faces-three.svg') }}">
                        </a>
                      </li>
                      @endif

                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                  @if(Auth::user()->inRole('invite-management'))
                                    <li>
                                      <a href="{{ route('invites.index') }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> Приглашения</a>
                                    </li>
                                  @endif

                                  @if(Auth::user()->inRole('user-management'))
                                    <li>
                                      <a href="{{ route('users.index') }}"><i class="fa fa-user-o" aria-hidden="true"></i> Пользователи</a>
                                    </li>
                                  @endif

                                  @if(Auth::user()->inRole('platform-management'))
                                    <li>
                                      <a href="{{ route('platforms.index') }}"><i class="fa fa-list-ul" aria-hidden="true"></i> Платформы</a>
                                    </li>
                                  @endif

                                  @if(Auth::user()->inRole('rule-management'))
                                    <li>
                                      <a href="{{ route('rules.index') }}"><i class="fa fa-gavel" aria-hidden="true"></i> Правила</a>
                                    </li>

                                    <li role="separator" class="divider"></li>
                                  @endif

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
