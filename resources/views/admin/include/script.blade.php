<!-- Required vendors -->
<script src="{{URL::asset('public/assets/admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Here is navigation script -->
<script src="{{URL::asset('public/assets/admin/vendor/quixnav/quixnav.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/quixnav-init.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/custom.min.js')}}"></script>

<!-- Demo scripts -->
<script src="{{URL::asset('public/assets/admin/js/styleSwitcher.js')}}"></script>

<!-- Daterange picker library -->
<script src="{{URL::asset('public/assets/admin/vendor/circle-progress/circle-progress.min.js')}}"></script>

<!-- Vectormap -->
<script src="{{URL::asset('public/assets/admin/vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/vendor/jqvmap/js/jquery.vmap.world.js')}}"></script>

<!-- calender -->
<script src="{{URL::asset('public/assets/admin/vendor/calender/calender.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/plugins-init/calender-init.js')}}"></script>

<!-- Chart Morris plugin files -->
<script src="{{URL::asset('public/assets/admin/vendor/raphael/raphael.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/vendor/morris/morris.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/vendor/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/dashboard/dashboard-1.js')}}"></script>

<!-- Datatable -->
<script src="{{URL::asset('public/assets/admin/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/plugins-init/datatables.init.js')}}"></script>

<!-- CKEditor -->
<!-- Bootstrap WYSIHTML5 -->
<script src="{{URL::asset('public/assets/admin/js/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{URL::asset('public/assets/admin/js/ckeditor/ckeditor.js')}}"></script>

<script>
	function deleteConfirmPopup( action )
	{
		var id = action.data('id');
        $('#modelConfirm').attr('data', id);
        $('#display_type').text(action.data('name'));
        $('#modelConfirm').attr('data-row-id', id);
        $('#modal-warning').modal();
	}

	function deletePopupSubmit( attribute, url, token, organizerTable )
	{
		var id = attribute.attr('data');
        var ths = attribute.attr('data');
        var data_row_id = attribute.attr('data-row-id');

		if (id != '') 
		{
			$.ajax({
                type: 'post',
                url: url,
                data: 'id=' + id + '&_token=' + token,
				beforeSend: function() { },
				success: function (data) {
					organizerTable.ajax.reload();
				}
			});
		}
	}
</script>