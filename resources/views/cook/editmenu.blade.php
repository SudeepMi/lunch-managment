@extends('cook.layout.cook')
@section('title','Set Menu')
@section('contents')
<div class="col-md-8 m-auto">
        <form method="post" class="update-menu-form">
                @csrf
<div class="portlet">
        <div class="toolbar">
                <div class="left toolbar-info">
                        <span class="toolbar-info-title"><i class="la la-cutlery"></i> <span class="title">Set Today Menu</span></span>
                </div>
        <div class="right">
                 <button class="btn btn-primary" type="submit"><i class="la la-check"></i> Save</button>
        </div>
        </div>
        <div class="portlet-body">

<input type="hidden" name="id" value="{{ $menus->id }}">
<div class="form-group col-md-6">
        @foreach($items as $olds)
        <label class="kt-option">
                <span class="kt-option__control">
                    <span class="kt-radio kt-radio--check-bold kt-radio--dark">
                            <input type="checkbox" name="item" class="custom-checkbox" value="{{ $olds->item }}"
                            @foreach($menus->item as $item)
                                    @if($item == $olds->item) checked  @endif
                            @endforeach >

                            <span></span>
                    </span>
                    </span>
            <span class="kt-option__label">
                <span class="kt-option__head">
                    <span class="kt-option__title">  {{ $olds->item }}<br</span>

                        </span>
                </span>
        </label>
    @endforeach
</div>
</form>
</div>
</div>
@endsection
@section('js')
<script>
    $(document).on('submit','.update-menu-form', function(e){
        e.preventDefault()
        var item = [];
        $.each($("input[name='item']:checked"),function(){
         item.push($(this).val())
        })
       var items = item.join(",")
        if(items == null){
            toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
        }else{
            $.ajax({
                method: "POST",
                url: url+"/cook/updatemenu",
                data: {  item: items, id: {{ $menus->id }} }
            }).done(function(res){
                if(res != "ok"){
                    toastr.error(res.message)
                }else{
                    toastr.success('Saved Successfully.', {timeOut: 5000})
                    window.location.href = '/cook';
                }
            }).fail( function(res){
                var errors = res.responseJSON.errors;
                for(key in errors){
                   toastr.error(errors[key])
                }
            })
        }
    })
</script>
@endsection

