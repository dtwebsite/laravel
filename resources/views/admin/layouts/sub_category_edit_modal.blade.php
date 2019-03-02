@section('sub_edit_modal')
<div class="modal fade" id="modal-sub-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">編輯子類別名稱</h4>
				</div>
			<div class="modal-body">
				<form id="sub_edit_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="edit_sub_title" class="col-sm-2 control-label">子類別名稱</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control">
								<input type="hidden" name="id">
							</div>
						</div>
					</div>
				</form>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary sub_edit_save">儲存</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
	function sub_edit(){
		$('.sub_edit').click(function(){
			var edit_title = $(this).parents('tr').find('td').eq(0).text();
			var edit_id = $(this).attr('data-id');
			$('#sub_edit_form [name=title]').val(edit_title);
			$('#sub_edit_form [name=id]').val(edit_id);

    		$('.sub_edit_save').click(function(){
    			$('#sub_edit_form').submit();
    			$('#modal-sub-edit').modal('hide');
    		})
    		$('#sub_edit_form').submit(function(){
    			var edit_data = $('#sub_edit_form').serialize();
    			$.post('{{ asset("admin/edit_commodity_category")}}',edit_data,'json');
    			swal(
					'更新成功！',
					'子類別名稱已更新。',
					'success'
				);
				category_list();
    			return false;
    		});
		})
	}
</script>
@endpush