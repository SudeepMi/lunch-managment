@extends('employee.layout.auth')
<?php
$menu = \App\Http\Controllers\MenuController::menus();

if (!is_null($menu)){ $items = explode(',',$menu->menu);}else{
    exit(redirect(url('cook')));
}

?>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <form method="post" action="{{ url('employee/storeorder') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="user" value="{{ \Illuminate\Support\Facades\Auth::guard('employee')->user()->name }}" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        @foreach($items as $item)
                        <input type="checkbox" name="item[]" class="custom-checkbox" value="{{ $item }}">{{ $item }}<br>

                            @endforeach
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="order">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection
