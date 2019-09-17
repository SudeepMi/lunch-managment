@extends('cook.layout.cook')
@section('title','Kitchen Staff')
@section('title','Home')
@section('contents')
<div class="col-lg-4">

 {!! $menu !!}

</div>


    <div class="col-lg-8">
            <div class="shadow-r ">
                    <div class="toolbar">
                        <div class="left toolbar-info">
                           <span class="toolbar-info-title"><i class="fas fa-user-tag"></i> <span class="title"> Orders</span></span>
                           </div>
                        <div class=" right">
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
                <th>name</th>
                <th>items</th>
                <th>time</th>
                <th>status</th>
                <th>action</th>
             </tr>
            </thead>

               @foreach($oder as $orders)
                   <tr>
                       <td> {{ $orders->name }} </td>
                       <td>{{ $orders->items }}</td>
                       <td>{{ $orders->created_at->format('m-d h:i') }}</td>
                       <td class="status" id="{{ $orders->status }}" >
                           @if($orders->status ==0) <span class="false">Pending</span>@endif
                           @if($orders->status ==1) <span class="true">Done</span>@endif
                       </td>
                       <td><a href="#" class="btn btn-danger btn-sm order-status" data-id="{{ $orders->id }}">Update Status</a>
                        
                    </td>

                   </tr>
                    @endforeach

        </table>
        </div>
    </div>
    </div>

@endsection

@section('js')
{{-- <script>
    $(document).on('click','.edit-menu', function(){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            method: "POST",
            url: url+"/cook/editmenu",
            data: { id: id}
        }).done( function(res){
            $(".editMenu").modal("show");
            $(".portlet-body").html(res);
        })
    })
</script> --}}

<script>
        $(document).on("click", ".order-status", function(e){
            e.preventDefault();

            var $this = $(this);
            var id = $this.data('id');
            console.log(id)
            if($this.parents('tr').find('.status').attr('id') == 1) {
                msgText     = 'Do you want to Inactivate this Employe ?';
                successMsg  = 'This Employe is Inactivated now.';
                errorMsg    = 'Sorry, Could not Inactivate this Employe at this time. Please try again.';
                content     = '<span class="false">Pending</span>';
                new_val     = 0;

            } else {
                msgText     = 'Do you want to Activate this Employe?';
                successMsg  = 'This Employe is Activated now.';
                errorMsg    = 'Sorry, Could not Activate this Employe at this time. Please try again.';

                content     = '<span class="true">Done</span>';
                new_val     = 1;

            }

            Swal.fire({
            title: 'Are you sure?',
            text: msgText,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'

            }).then( function(result) {
            if(result.value){

                $.ajax({
                    url: '/cook/orderdone',
                    data: {id: id},
                    type: 'POST',
                    success: function (response) {
                        if(response.status != 'failed'){
                            $this.parents('tr').find('.status').html(content);
                            $this.parents('tr').find('.status').attr('id', new_val);

                            Swal.fire(
                                'Updated!',
                                response.successMsg,
                                response.status
                                )
                        } else {
                            'Sorry!',
                            response.successMsg,
                            response.status
                        }
                    }
                });
            }
            })

        })
</script>
@endsection
@section('modals')
<div class="modal fade  modals editMenu" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit Mebu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
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
