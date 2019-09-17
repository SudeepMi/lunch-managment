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
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">

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
                <a class="navbar-brand" href="{{ url('/cook') }}">
                    LunchHour : KitchenStaff
                </a>
            </div>
            <ul class="nav">

            </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-right">
                    <!-- Authentication Links -->
                    @if(Auth::guard('cook')->user() !== null)
                    <li class="nav-link">
                        <div class="dropdown">
                            <a class="menu-toggle" data-toggle="dropdown">
                                    <i class="fas fa-bars"></i> Menu
                            </a>
                            <div class="dropdown-menu menus">
                                <a href="{{ url('cook/addmenu') }}" class="dropdown-item set-menu-link"><i class="la la-tasks"></i> Set Today Menu</a>
                                <a href="{{ url('cook/items') }}" class="dropdown-item"><i class="la la-list-alt"></i> Items</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-link">
                        <div class="dropdown">
                            <a class="drop-toggle" data-toggle="dropdown">
                                <i class="far fa-user"></i> {{ Auth::guard('cook')->user()->name }} <span class="caret"></span>
                            </a>
                        <div class="dropdown-menu links">
                            @notactive('cook')
                            <a class="dropdown-item ask-for-active" href="#">
                                <i class="la la-share"></i> Ask For Activation
                            </a>
                            @elseactive
                                <a class="dropdown-item" href="#">Link 1</a>
                                <a class="dropdown-item" href="#">Link 2</a>
                                <a class="dropdown-item" href="#">Link 3</a>
                            @endactive
                            </div>
                        </div>
                        </li>
                        <li class="nav-link">
                                <a href="{{ url('/cook/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>  Logout
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

    @notactive('cook')
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Account Not Activated !</strong> Please Contact Your Administration.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                </div>
            </div>
        </div>
    @elseactive
    <div class="container">
            <div class="row">
    @yield('contents')
    @endactive


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
<script src="{{ asset('js/toastr.min.js') }}"></script>
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

        $(".drop-toggle").on('click', function(e){
            $(".links").toggle();
        })

        $(".menu-toggle").on('click', function(e){
            $(".menus").toggle();
        })

        $(document).ready( function () {
            $('#datatable').DataTable();
        } );
        $(".ask-for-active").on('click',function(){
            toastr.options.closeMethod = 'slideUp';
            toastr.success('please wait while your request is proccessing','Send Successfully.', {timeOut: 5000})
        })
        $('html').click(function(e) {
            //if clicked element is not your element and parents aren't your div
            if (e.target.className != 'menus' && $(e.target).parents('.menu-toggle').length == 0) {
                $(".menus").hide();
            }
            if (e.target.className != 'links' && $(e.target).parents('.drop-toggle').length == 0) {
                $(".links").hide();
            }
            if (e.target.className != 'export-tool' && $(e.target).parents('.export').length == 0) {
                $(".export-tool").hide();
            }
          });
          var url = "{{ url('/') }}";
</script>
@notactive('cook')
    <script>
        $(document).ready( function(){
            $('.menus').html("<a href='#' class='dropdown-item'>not aviable right now</a>");
        })

    </script>
@endactive
@yield('js')
</body>
</html>






