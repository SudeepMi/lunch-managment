@extends('employee.layout.auth')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card mt-5" style="width:100%;">
                    @if(is_null($completed))
                        <div class="card-header">
                          no notifications yet
                        </div>
                    @else
                        <div class="card-header">
                           Notifications
                        </div>
                        <ul class="list-group list-group-flush">

                            @foreach($completed as $new)
                                <li class="list-group-item">
                                    @if($new->status == 0)
                                        your order from {{ \Carbon\Carbon::parse($new->created_at)->toDateString()  }} is recieved by us.
                                        @else
                                        your order from {{ $new->created_at }} is completed.
                                        you can take your lunch.
                                    @endif
                                </li>

                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @endsection