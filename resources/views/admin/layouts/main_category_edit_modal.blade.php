@section('main_edit_modal')
<div class="modal fade" id="modal-main-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">編輯類別名稱</h4>
				</div>
			<div class="modal-body">
				<form id="edit_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="edit_title" class="col-sm-2 control-label">類別名稱</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control">
								<input type="hidden" name="id">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
	function main_edit(){
		$('.main_edit').click(function(){
			var edit_title = $(this).parent().find('h2').text();
			var edit_id = $(this).attr('data-id');
			$('#edit_form [name=title]').val(edit_title);
			$('#edit_form [name=id]').val(edit_id);
		})
	}

	$('#edit_form').submit(function(){
		var edit_data = $('#edit_form').serialize();
		$.post('{{ asset("admin/edit_commodity_category")}}',edit_data,'json');
		swal(
			'更新成功！',
			'類別名稱已更新。',
			'success'
		);
		$('#modal-main-edit').modal('hide');
		category_list();
		return false;
	});
</script>
@endpush