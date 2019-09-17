@extends('employee.layout.auth')

@section('content')
@if( Auth::guard('employee')->user()->active == 0)

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                your account has not been yet confirmed. please contact adminidtration
            </div>
        </div>
    </div>

@else

    <?php
    $menu = \App\Http\Controllers\MenuController::menus();

    if (!is_null($menu)){ $items = explode(',',$menu->menu);}

    ?>


<div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card mt-5" style="width:100%;">
                    @if(is_null($menu))
                        <div class="card-header">
                            menu not set
                        </div>
                    @else
                        <div class="card-header">
                            Today's Menu<br>
                            Posted {{ $menu->diff }}
                            <a href="{{ url('employee/orderlunch') }}" class="float-right">Order</a>
                        </div>
                        <ul class="list-group list-group-flush">

                            @foreach($items as $item)
                                <li class="list-group-item">{{ $item }}</li>

                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection