<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Notions</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
            margin-top: 10%;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        a:hover {
            color: blue;
            background-color: grey;
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    @can('manage-users')
                                    <a class="dropdown-item" href="{{route('admin.user.index')}}">User mangement</a>
                                    @endcan
                                    @can('manage-users')
                                    <a class="dropdown-item" href="{{route('admin.poll.index')}}">Poll mangement</a>
                                    @endcan
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @include('partials.alerts')
                @yield('content')
            </div>

        </main>
    </div>
    <div class="container">
        <div class="content ">
            <div class="title">
                SISTEMA DE VOTAÇÃO <img
                    src="https://s3-sa-east-1.amazonaws.com/projetos-artes/fullsize%2F2016%2F07%2F08%2F18%2FLogo-188692_290593_183327325_521631295.jpg"
                    widht="100px" height="100px" alt="">
                @if (Route::has('login'))
                    <div class="links">
                        @auth
                            @can('manage-users')
                                <a href="{{ url('/admin/user') }}">Administrar Usuarios</a>
                                <a href="{{ url('/admin/poll') }}">Administrar Enquetes</a>
                            @endcan
                            @can('vote')
                            <a href="{{ route('home.index') }}">Ver Enquetes</a>
                            @endcan
                                <h5>Para votar precisa ter minimo uma permissão basica de 'user' no sistema!</h5>
                                <h5>Quando administrador te der essa permissão voce podera usar o sistema!</h5>
                        @else
                            <a href="{{ route('login') }}">Entra</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Registrar-se</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

    </div>

</body>

</html>
