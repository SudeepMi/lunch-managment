@extends('cook.layout.cook')
@section('title','Set Menu')
@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                    <div class="portlet">
                            <form class="set-menu-form" method="POST">
                                <div class="toolbar">
                                        <div class="left toolbar-info">
                                                <span class="toolbar-info-title"><i class="la la-cutlery"></i> <span class="title">Set Today Menu</span></span>
                                        </div>
                                <div class="right">
                                         <button class="btn btn-primary"><i class="la la-check"></i> Save</button>
                                </div>
                                </div>
                                         <div class="portlet-body">
                                          @csrf
                                            <div class="form-group col-md-6">
                        @foreach($items as $item)
                        <label class="kt-option">
                                <span class="kt-option__control">
                                    <span class="kt-radio kt-radio--check-bold kt-radio--dark">
                                            <input type="checkbox" name="item" id="items" class="" value="{{ $item->item }}">
                                            <span></span>
                                    </span>
                                    </span>
                            <span class="kt-option__label">
                                <span class="kt-option__head">
                                    <span class="kt-option__title">{{ $item->item }}</span>

                                        </span>
                                </span>
                        </label>

                    @endforeach
                                            </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    $(document).on('submit','.set-menu-form', function(e){
        e.preventDefault()
        var item = [];
        $.each($("input[name='item']:checked"),function(){
         item.push($(this).val())
        })
       var items = item.join(", ")
        if(items == null){
            toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
        }else{
            $.ajax({
                method: "POST",
                url: url+"/cook/addmenu/save",
                data: {  item: items }
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
