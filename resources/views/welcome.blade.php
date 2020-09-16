<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Notions</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
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

            .links > a {
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

            a:hover{
                color: blue;
                background-color: grey;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content ">
                <div class="title">
                    SISTEMA DE VOTAÇÃO <img src="https://s3-sa-east-1.amazonaws.com/projetos-artes/fullsize%2F2016%2F07%2F08%2F18%2FLogo-188692_290593_183327325_521631295.jpg" widht="100px" height="100px" alt="">
                    @if (Route::has('login'))
                    <div class="links">
                        @auth
                            <a href="{{ url('/admin/user') }}">Administrar Usuarios</a>
                            <a href="{{ url('/admin/poll') }}">Administrar Enquetes</a>
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
