<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}: Employee
                </a>
            </div>

           <!-- Left Side Of Navbar -->
            @if (!Auth::guest())
                <ul class="nav ">
                    <li class="nav-link"><a href="{{ url('employee/notifications') }}">Notifications </a></li>
                    <li class="nav-link"><a href="{{ url('employee/home') }}">home </a></li>

                </ul>
@endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/employee/login') }}">Login</a></li>
                        <li><a href="{{ url('/employee/register') }}">Register</a></li>
                    @else
                        <li class="d-inline-block">

                                {{ Auth::user()->name }} <span class="caret"></span>

                        </li>

                        <li class="d-inline-block">
                            <a href="{{ url('/cook/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                                    <form id="logout-form" action="{{ url('/employee/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>

                    @endif

            </div>

    </nav>

    @if ( Session::has('success'))
        <div class="col-md-3 m-auto" id="flash">
            <div class="alert alert-success">
                <p> {{ Session::get('success') }}
                    <a href="#" onclick="setTimeout(function () {document.getElementById('flash').style.display='none'}, 100);return false" style="float: right;" class="m-auto">&times;</a>
                </p>
            </div>
        </div>
    @endif


    @yield('content')

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
