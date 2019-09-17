@extends('cook.layout.cook')
@section('title','Add Menu Item')
@section('contents')
     <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="shadow-r ">
                 <div class="toolbar">
                        <div class="left toolbar-info">
                                <span class="toolbar-info-title"><i class="la la-cutlery"></i> <span class="title"> Menu Items</span></span>
                        </div>
                <div class="right">

                         <button class="btn btn-transparent export">
                            <span class="kt-nav__section-text">Export Tools</span>
                        </button>
                    <div class="dropdown-menu export-tool dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_print">
                                    <i class="kt-nav__link-icon la la-print"></i>
                                    <span class="kt-nav__link-text">Print</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_copy">
                                    <i class="kt-nav__link-icon la la-copy"></i>
                                    <span class="kt-nav__link-text">Copy</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_excel">
                                    <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                    <span class="kt-nav__link-text">Excel</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_csv">
                                    <i class="kt-nav__link-icon la la-file-text-o"></i>
                                    <span class="kt-nav__link-text">CSV</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_pdf">
                                    <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                    <span class="kt-nav__link-text">PDF</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
                    <table class="table table-styled table-hover table-striped table-sm table-bordered  table-checkable dataTable-init" id="datatable">

                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>item</th>
                            <th>unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                    @foreach($items as $item)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td>{{ $item->item}}</td>
                            <td>{{ $item->unit }}</td>
                            <td><a href="#" class="btn btn-success item-edit" data-item="{{ $item->item }}" data-unit="{{ $item->unit }}" data-id="{{ $item->id }}">Edit</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
     </div>
            <div class="col-lg-6">
                <div class="portlet">
            <form class="add-item-form" method="POST">
                <div class="toolbar">
                        <div class="left toolbar-info">
                                <span class="toolbar-info-title"><i class="la la-cutlery"></i> <span class="title">Add Menu Items</span></span>
                        </div>
                <div class="right">
                         <button class="btn btn-primary" type="submit"><i class="la la-check"></i> Save</button>
                </div>
                </div>
                         <div class="portlet-body">
                                @csrf
                           <div class="form-group col-md-6">
                               <label for="item">Name :</label>
                                   <input type="text" id="item" class="form-control @error('item') is-invalid @enderror" name="item" autofocus required>
                                   @error('item')
                                       <span class="help-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                   @enderror
                           </div>
                           <div class="form-group col-md-6">
                               <label>Unit :</label>
                                <select class="form-control kt-selectpicker @error('unit') is-invalid @enderror" name="unit" id="unit" data-live-search="true" required>
                                        <option disabled selected>Select Any</option>
                                        <option value="plates">plate</option>
                                        <option value="piece">piece</option>
                                        <option value="cup">cup</option>

                                    </select>
                                    @error('unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@section('js')
       <script>
            toastr.options.progressBar = true;
            $(document).on('submit','.add-item-form',function(e){
                e.preventDefault()
                var unit = $("#unit").val()
                var item = $("#item").val()
                if(unit == null || item == null){
                    toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
                }else{
                    $.ajax({
                        method: "POST",
                        url: url+"/cook/additem",
                        data: { unit: unit, item: item }
                    }).done(function(res){
                        if(res != "ok"){
                            toastr.error(res.message)
                        }else{

                            toastr.success('Saved Successfully.', {timeOut: 5000})
                            location.reload()
                        }
                    }).fail( function(res){
                        console.clear()
                        var errors = res.responseJSON.errors;
                        for(key in errors){
                           toastr.error(errors[key])
                        }
                    })
                }
            })
       </script>
       <script>
           $(document).on('click','.item-edit', function(){
                var item = $(this).data('item')
                var unit = $(this).data('unit')
                var id = $(this).data('id')

                var form = '<div class="form-group col-md-6"><label for="item">Name :</label>'
                            +'<input type="text" id="eitem" class="form-control" name="item" value="'+item+'" autofocus required>'
                            +'</div><div class="form-group col-md-6"><label>Unit :</label>'
                         +'<select class="form-control kt-selectpicker unit" name="units" id="units" data-live-search="true" required>'
                        +'<option disabled selected>Select Any</option><option value="plates">plate</option><option value="piece">piece</option><option value="cup">cup</option>'
                        +'</select><input type="hidden" name="eid" id="eid" value="'+id+'"></div>';
                $(".editItem").modal("show");
                $('.portlet-body').html(form);
                         })
            $(".edit-item-form").on('submit', function(e){
                var data = $(this).serializeArray()
                e.preventDefault()
                var item = $("#eitem").val()
                var units = data[1]['value'];
                var id = $("#eid").val()
                if(units == null || item == null){
                    toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
                }else{
                    $.ajax({
                        method: "POST",
                        url: url+"/cook/edititem",
                        data: { unit: units, item: item, id: id }
                    }).done(function(res){
                        if(res != "ok"){
                            toastr.error(res.message)
                        }else{

                            toastr.success('Saved Successfully.', {timeOut: 5000})
                            location.reload()
                        }
                    }).fail( function(res){
                        console.clear()
                        var errors = res.responseJSON.errors;
                        for(key in errors){
                           toastr.error(errors[key])
                        }
                    })
                }
            })
       </script>
@endsection
@section('modals')
<div class="modal fade  modals editItem" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit Mebu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="edit-item-form">
            <div class="modal-body">
                  <div class="">
                        <div class="portlet-header">
                            <span class="portlet_toolbar">
                                <p class="left">Edit Mebu</p>
                            </span>
                        </div>
                        <div class="portlet-body row">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
          </div>
        </div>
      </div>
@endsection
