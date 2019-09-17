@extends('admin.layout.auth')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">


                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Items</th>
                        <th scope="col">Menu Date/Time</th>





                    </tr>
                    </thead>
                    <tbody>
                    @php($i =1)
                    @foreach($older as $emp)

                        <tr>
                            <th scope="row">{{ $i++ }}</th>

                            <td>
                               {{ $emp->menu }}
                            </td>

                            <td>
                                {{ $emp->created_at }}
                            </td>

                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
