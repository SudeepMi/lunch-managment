@if(is_null($menu))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Empty !</strong> Menu  not set for today.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

@else

<div class="portlet">
        <div class="card-header" style="height:100px">
            <div class="left">
            <h5> Menu of day</h5>
            <span class="d-block">Posted at {{ $menu->created_at->format('m-d h:i') }}</span>
            <span class="d-block">Updated at {{ $menu->updated_at->format('m-d h:i') }}</span>
         <span class="d-block">Posted By {{ $menu->created_by }}</span>

            </div>
            <div class="right">
            <a href="{{ route('editmenu', $menu->id) }}" data-id="{{ $menu->id }}" class="btn btn-sm btn-primary edit-menu"><i class="la la-edit"></i> Edit</a>
        </div>
        </div>
        <ul class="list-group list-group-flush">

            @foreach($menu->items as $item)
            <li class="list-group-item">{{ $item }}</li>

                @endforeach
        </ul>
</div>
@endif
