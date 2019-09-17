<!DOCTYPE html>
<html lang="en">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LunchHour | @yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/global/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">



    <style>
        @yield('css')
    </style>
    <!-- Scripts -->
    <script src="{{ asset('assets/webfont/1.6.16/webfont.js')}}"></script>
        <script>
        WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            })
        </script>
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
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/admin') }}">
                    LunchHour : Admin
                </a>
            </div>
            <ul class="nav">

                </ul>
                @if(Auth::guard('admin')->user() !== null)
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-right">
                        <li class="nav-link">
                            <div class="dropdown">
                            <a class="drop-toggle" data-toggle="">
                                    <i class="fas fa-bars"></i><span> Menu</span>
                            </a>
                            <div class="dropdown-menu links">
                  <a href="{{ url('admin/stafflist') }}" class="dropdown-item"><i class="fas fa-utensils"></i> kitchen staff</a>
                    <a href="{{ url('admin/emplist') }}" class="dropdown-item"><i class="fas fa-user-tie"></i> Employees</a>
                      <a href="{{ url('admin/menu') }}" class="dropdown-item"><i class="fas fa-clipboard-list"></i> Todays Menu</a>
                       <a href="{{ url('admin/orders') }}" class="dropdown-item"><i class="fas fa-th-list"></i> Orders</a>
                            </div>
                        </div>
                    </li>
                    <!-- Authentication Links -->

                <li class="nav-link"><a href="#"><i class="far fa-user"></i> {{ Auth::guard('admin')->user()->name }} <span class="caret"></span></a></li>
                <li class="nav-link">
                    <a href="{{ url('/cook/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>  Logout
                    </a>
                    <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                </li>
             @endif
                </ul>
            </div>
        </nav>



    <div class="container">
        <div class="row">
    @yield('contents')

    @yield('modals')
    <!-- Scripts -->
</div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/table-init.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','.export', function(){
            $(".export-tool").toggle()
        })

        $(document).ready( function () {
            $('#datatable').DataTable();
        } );

        $(".drop-toggle").on('click', function(e){
            $(".links").toggle();
        })

        $('html').click(function(e) {
            //if clicked element is not your element and parents aren't your div
            if (e.target.className != 'menus' && $(e.target).parents('.menu-toggle').length == 0) {
                $(".menus").hide();
            }
            if (e.target.className != 'links' && $(e.target).parents('.drop-toggle').length == 0) {
                $(".links").hide();
            }
          });


</script>
@yield('js')
</body>
</html>




