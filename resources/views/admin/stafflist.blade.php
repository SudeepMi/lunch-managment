@extends('admin.layout.admin')
@section('title','Kitchen Staff List')
@section('contents')

     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="shadow-r ">
         <div class="toolbar">
                <div class="left toolbar-info">
                        <span class="toolbar-info-title"><i class="la la-cutlery"></i> <span class="title"> Kitchen Staff</span></span>
                        </div>
             <div class="right">
                 <button class="btn btn-primary add-staff-btn"><i class="fas fa-plus"></i> Add Staff</button>
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
                        <th>SN</th>
                        <th>email</th>
                        <th>name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>status</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                        {{--  {{ dd($staffs) }}  --}}
                    @foreach($staffs as $staff)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->phone }}</td>
                        <td>{{ $staff->address }}</td>
                        <td class="active-controll" data-id="{{ $staff->id }}" id="{{ $staff->active }}">
                            @if( $staff->active ==0)
                            <span class="false">Unconfirmed</span>
                            @else
                            <span class="true">Confirmed</span>
                          @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/editstaff',['id'=>$staff->id]) }}" data-id="{{ $staff->id }}" data-name="{{ $staff->name }}" data-email="{{ $staff->email }}" class="btn btn-success edit-cooks"><i class="fas fa-edit"></i> Edit</a>
                            <a href="#" data-id="{{ $staff->id }}" class="btn btn-danger status-staff"><i class="fas fa-ban"></i> Update status</a>
                        </td>

                    </tr>
                @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
$(document).on("click", ".status-staff", function(e){
    e.preventDefault();

    var $this = $(this);
    var id = $this.data('id');
    console.log(id)
    if($this.parents('tr').find('.active-controll').attr('id') == 1) {
        msgText     = 'Do you want to Inactivate this Kitchen Staff ?';
        successMsg  = 'This Kitchen Staff is Inactivated now.';
        errorMsg    = 'Sorry, Could not Inactivate this Kitchen Staff at this time. Please try again.';
        content     = '<span class="false">Unconfirmed</span>';
        new_val     = 0;

    } else {
        msgText     = 'Do you want to Activate this Kitchen Staff?';
        successMsg  = 'This Kitchen Staff is Activated now.';
        errorMsg    = 'Sorry, Could not Activate this Kitchen Staff at this time. Please try again.';

        content     = '<span class="true">Confirmed</span>';
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
            url: '/admin/cook/change-status',
            data: {id: id},
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },

            success: function (response) {
                if(response.status != 'failed'){
                    $this.parents('tr').find('.active-controll').html(content);
                    $this.parents('tr').find('.active-controll').attr('id', new_val);

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

$(document).on('click','.edit-cooks', function(e){
    e.preventDefault();
    var id = $(this).data('id')
    var name = $(this).data('name')
    var email = $(this).data('email')
    $('.modals').modal('show');
    $('.modal-body').html('<div class="form-group"><label>Name</label><input class="form-control " value="'+name+'" type="text" name="name" required></div>'+
    '<div class="form-group"><label>Email</label><input class="form-control" type="email" name="email" value="'+email+'"required>'+
        '<input type="hidden" name="id" value="'+id+'"></div>')
})

$(document).on('submit','.edit-cooks-form', function(e){
    e.preventDefault();
   var data = JSON.stringify($(this).serializeArray());
    console.log(data)
    $.ajax({
        method: "POST",
        url: '/admin/cook/update',
        data: {datas: data},
    }).done(function(res){
        console.log(res)
        if(res != "failed") {
            location.reload();
            Swal.fire({
                position: 'center',
                type: 'success',
                title: 'Saved',
                showConfirmButton: false,

            })
        } else { console.log('issue');
            Swal.fire(
                'Sorry!',
                response.errorMsg,
                response.status
            )
        }
    })
})

$(document).on('click','.add-staff-btn', function(e){
    e.preventDefault();
    $('.addstaff').modal('show');
})
</script>
@endsection
@section('modals')



<!-- Modal -->
<div class="modal fade  modals" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Kitchen Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="edit-cooks-form" method="POST">
      <div class="modal-body">
            @csrf
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade modals addstaff" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <form method="POST" action="{{ route('addStaff') }}">
                            @csrf
                            <div class="portlet">
                                <div class="portlet-header">
                                    <span class="portlet_toolbar">
                                        <p class="left">Add Kitchen Staff</p>
                                    </span>
                                </div>
                                <div class="portlet-body row">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required>
                                            @error('name')
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                            <label>Address</label>
                                                <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" required>
                                                @error('address')
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @enderror
                                        </div>


                                        <div class="form-group">
                                                <label>Phone</label>
                                                    <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" required>
                                                    @error('phpne')
                                                    <span class="help-block">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required>
                                            @error('email')
                                            <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                                            @error('name')
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save </button>
            </div>
          </form>
          </div>
        </div>
      </div>
@endsection
