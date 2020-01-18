<?php $adminURL = config('constants.ADMIN_URL');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
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
     Organizer Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li> 
      <li><a href="#">Tables</a></li>
      <li class="active">Data tables</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
    <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{URL::asset('public/assets/admin/dist/img/user3-128x128.jpg')}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$organizerData->full_name}}</h3>

              <p class="text-muted text-center">{{$organizerData->about_promoter}}</p>

              <div class="col-md-6"><b>Full Name</b> : {{$organizerData->full_name}}</div>
              <div class="col-md-6"><b>First Name</b> : {{$organizerData->first_name}}</div>
              <div class="col-md-6"><b>Last Name</b> : {{$organizerData->last_name}}</div>
              <div class="col-md-6"><b>Email</b> : {{$organizerData->email}}</div>
              <div class="col-md-6"><b>Mobile Number</b> : {{$organizerData->mobile_number}}</div>
              <div class="col-md-6"><b>Location</b> : {{$organizerData->location}}</div>
              <div class="col-md-6"><b>Unique Url</b> : {{$organizerData->unique_url}}</div>
              <div class="col-md-6"><b>Website</b> : {{$organizerData->website}} </div>
              <div class="col-md-6"><b>Facebook</b> : {{$organizerData->fb_url}} </div>
              <div class="col-md-6"><b>Skype</b> : {{$organizerData->skype_url}} </div>
              <div class="col-md-6"><b>Instagram</b> : {{$organizerData->insta_url}} </div>
              <div class="col-md-6"><b>Twitter</b> : {{$organizerData->twitter}} </div>
              <div class="col-md-6"><b>Snapchat</b> : {{$organizerData->snapchat}} </div>
              <div class="col-md-6"><b>Status</b> : <small class="label bg-{{$organizerData->status?'green':'red'}}">{{$organizerData->status?'Active':'Inactive'}}</small></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
</div>
@include('admin.include.footer')
@include('admin.include.script')

<script type="text/javascript">
    $(function (){
    $('#example1').DataTable()({
      "scrollX": true,
      'autoWidth'   : true,
    })
  })

     $(document).ready(function() {
            $('.active_user').on('click', function(){
            var id = $(this).attr('data-id');
            var token = '{{ csrf_token() }}';
            var status = $(this).attr('user-status');
            var ths = $(this);
            if (id != '') {
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/activeOrgnizer')}}",
                    data: 'id=' + id + '&_token=' + token,
                    beforeSend: function() {
                    },
                    success: function (data) {
                        if(data==1)
                        {
                          $(ths).html('Active');
                          $(ths).addClass("btn-success");
                        }
                        else
                        {
                          $(ths).html('Inactive');
                          $(ths).addClass("btn-danger");
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
                    url: "{{ url('Admin/deleteOrganizer')}}",
                    data: 'id=' + id + '&_token=' + token,
                    beforeSend: function() {
                    },
                    success: function (data) {
                        $('.'+id).hide();
                    }
                })
            }  
        });

        $('.delete_category').on('click', function(){
            var id = $(this).attr('data-id');
            $('#modelConfirm').attr('data', id);
            $('#modelConfirm').attr('data-row-id', $(this).closest('tr').attr('data-row'));
            $('#modal-warning').modal();
            return false;
        });
    });
</script>
<script>
  

</script>
</body>
</html>


