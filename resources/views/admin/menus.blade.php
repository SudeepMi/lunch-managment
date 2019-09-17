@extends('admin.layout.admin')

@section('contents')
    <?php
    $menu = \App\Http\Controllers\MenuController::menus();

    if (!is_null($menu)){ $items = explode(',',$menu->menu);}

    ?><div class="container">
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
                        </div>
                        <ul class="list-group list-group-flush">

                            @foreach($items as $item)
                                <li class="list-group-item">{{ $item }}</li>

                            @endforeach
                        </ul>
                    @endif
                </div>
                <a href="{{ url('admin/oldermenus') }}">older menus</a>
            </div>
        </div>

    </div>

@endsection


