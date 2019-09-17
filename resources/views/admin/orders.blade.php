@extends('admin.layout.admin')

@section('contents')

    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">

                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Items</th>
                        <th scope="col">date</th>
                        <th scope="col">status</th>

                    </tr>
                    </thead>
                    <tbody>
                    @php($i =1)
                    @foreach($recent as $emp)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $emp->name }}</td>
                            <td>
                                {{ $emp->items }}
                            </td>

                            <td>
                                {{ $emp->created_at }}
                            </td>
                            <td>
                                @if($emp->status == 0)
                                   Uncomplete
                                    @else
                                    Completed
                                    @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
