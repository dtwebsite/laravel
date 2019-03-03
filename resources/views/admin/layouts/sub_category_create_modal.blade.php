@section('sub_create_modal')
{{-- 新增功能Start --}}
<div class="modal fade" id="modal-sub-create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">新增子類別</h4>
			</div>
			<div class="modal-body">
				<form id="sub_create_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="create_sub_title" class="col-sm-2 control-label">子類別名稱</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" required="required" placeholder="請輸入子類別名稱">
							</div>
							<input type="hidden" name="level" value="1">
								<input type="hidden" name="up_id">
						</div>
					</div>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{-- 新增功能End --}}
@endsection
@push('script')
<script type="text/javascript">
	function sub_create(){
		$('.sub_create').click(function(){
			var up_id = $(this).attr('data-id');
			$('#modal-sub-create').modal('show');
			$('#sub_create_form [name=up_id]').val(up_id);
		})
	}
	$('#sub_create_form').submit(function(){
		var insert_data = $('#sub_create_form').serialize();
		$.post('{{ asset("admin/insert_commodity_category")}}',insert_data,'json');
		swal(
			'新增成功！',
			'已新增子類別。',
			'success'
		);
		$('#modal-sub-create').modal('hide');
		category_list();
		return false;
	});
</script>
@endpush