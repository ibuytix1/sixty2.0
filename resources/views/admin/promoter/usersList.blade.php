<?php $adminURL = config('constants.ADMIN_URL');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | User List</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  @include('admin.include.css')
</head>
<body class="skin-blue">
 @include('admin.include.header')
 @include('admin.include.sidebar')
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Users List 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> 
      <li><a href="#">Users</a></li>
      <li class="active">Users List</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr No</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Register At</th>
                
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              
                  <?php $i=1; ?>
                  @foreach ($data as $user)
                    <tr class="{{$user->id}}">
                  <td>{{$i}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->created_at}}</td>
                  <td><button type="button" class="btn btn-block <?php if($user->status==1){echo "btn-success";}else{echo 'btn-danger';}?> btn-xs active_user" id="active_user" data-id="{{$user->id}}" user-status="1"><?php if($user->status==1){echo "Unhide";}else{echo 'Hide';}?></button></td>
                  <td><div class="btn-group">
                  <button type="button" class="btn btn-info btn-xs">Action</button>
                  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url($adminURL.'userDetail/'.$user->id) }}">View Detail</a></li>
                    <li><a href="#" class="delete_user"data-id="{{$user->id}}">Delete</a></li>
                  </ul>
                </div></td>
                   </tr>
                    <?php $i++; ?>
                  @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Sr No</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Register At</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

   <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning</h4>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete this user  ? &hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline deleteConfirm" id="modelConfirm" data-row-id='' data-dismiss="modal">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
</div>
@include('admin.include.footer')
@include('admin.include.script')
<script type="text/javascript">
    $(function (){
    $('#example1').DataTable()({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>

   $(document).ready(function() {

     $('.active_user').on('click', function(){
            var id = $(this).attr('data-id');
            var token = '{{ csrf_token() }}';
            var status = $(this).attr('user-status');
            var ths = $(this);
            if (id != '') {
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/activeUser')}}",
                    data: 'id=' + id + '&_token=' + token,
                    beforeSend: function() {
                    },
                    success: function (data) {
                        if(data==0)
                        {
                          $(ths).html('Hide');
                          $(ths).removeClass("btn-success");
                          $(ths).addClass("btn-danger");
                        }
                        else
                        {
                          $(ths).html('Unhide');
                           $(ths).removeClass("btn-danger");
                          $(ths).addClass("btn-success");
                        }
                    }
                })
            }  
        });
        $('#modal-warning').on('click', '.deleteConfirm', function(){
            var id = $(this).attr('data');
            var token = '{{ csrf_token() }}';
            var ths = $(this).attr('data');
            var data_row_id = $(this).attr('data-row-id');
            if (id != '') {
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/deleteUser')}}",
                    data: 'id=' + id + '&_token=' + token,
                    beforeSend: function() {
                    },
                    success: function (data) {
                        $('.'+id).hide();
                    }
                })
            }  
        });
        $('.delete_user').on('click', function(){
            var id = $(this).attr('data-id');
            $('#modelConfirm').attr('data', id);
            $('#modelConfirm').attr('data-row-id', $(this).closest('tr').attr('data-row'));
            $('#modal-warning').modal();
            return false;
        });
    });
  

</script>
</body>
</html>


