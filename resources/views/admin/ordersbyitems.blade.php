@extends('admin.layout.auth')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <a href="{{ url('admin/orders') }}">Watch By Employee</a>

                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Items</th>


                    </tr>
                    </thead>
                    <tbody>
                    @php($i =1)
                    @foreach($new as $emp=>$b)

                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $emp }}</td>
                            <td>
                                @foreach($b as $items)
                                         <li> {{ $items }}</li>

                                @endforeach
                                </td>





                        </tr>
                            @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
