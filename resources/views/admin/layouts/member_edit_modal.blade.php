@section('edit_modal')
<div class="modal fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">編輯內容</h4>
				</div>
			<div class="modal-body">
				<form id="edit_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="edit_name" class="col-sm-2 control-label">會員名稱</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="edit_email" class="col-sm-2 control-label">會員信箱</label>
							<div class="col-sm-10">
								<input type="text" name="email" class="form-control">
								<input type="hidden" name="id">
							</div>
						</div>
					</div>
				</form>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary member_save">儲存</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
	function member_edit(){
		$('.edit').click(function(){
			var edit_name = $(this).parents('tr').find('td').eq(1).text();
			var edit_email = $(this).parents('tr').find('td').eq(2).text();
			var edit_id = $(this).attr('data-id');

			$('#edit_form [name=name]').val(edit_name);
			$('#edit_form [name=email]').val(edit_email);
			$('#edit_form [name=id]').val(edit_id);

    		$('.member_save').click(function(){
    			$('#edit_form').submit();
    			$('#modal-edit').modal('hide');
    		})
    		$('#edit_form').submit(function(){
    			var data = {};
    			var edit_data = $('#edit_form').serialize();
    			$.post('{{ asset("admin/member_edit")}}',edit_data,'json');
    			swal(
					'更新成功！',
					'會員資料已更新。',
					'success'
				);
				member_list(data);
    			return false;
    		});
		})
	}
</script>
@endpush