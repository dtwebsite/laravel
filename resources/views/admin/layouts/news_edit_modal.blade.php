@section('edit_modal')
{{-- 修改功能Start --}}
<div class="modal fade" id="modal-edit">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">修改最新消息</h4>
			</div>
			<div class="modal-body">
				<form id="edit_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="edit_title" class="col-sm-1 control-label">標題</label>
							<div class="col-sm-11">
								<input type="text" name="title" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="status" class="col-sm-1 control-label">狀態</label>
							<div class="col-sm-11">
								<select id="status" name="status" class="form-control">
									<option value="" selected="selected">請選擇</option>
									<option value="1">啟用</option>
									<option value="0">停用</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="edit_content" class="col-sm-12 control-label" style="padding:0;">內容</label>
							<textarea></textarea>
						</div>
						<input type="hidden" name="id">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary news_edit_save">儲存</button>
			</div>
		</div>
	</div>
</div>
@endsection
{{-- 修改功能End --}}
@push('script')
<script type="text/javascript">
	function news_edit(){
		$('.edit').click(function(){
			$('#modal-edit').modal('show');
			var edit_id = $(this).attr('data-id');
			$.post('{{ asset('admin/get_edit_data') }}',{ id : edit_id , _token : '{{ csrf_token() }}' },function(res){
				var edit_title = res.title;
				var edit_status = res.status;
				var edit_content = res.content;
				$('#edit_form [name=id]').val(edit_id);
				$('#edit_form [name=title]').val(edit_title);
				$('#edit_form [name=status]').val(edit_status);
				tinymce.activeEditor.setContent(edit_content);
			},'json');
			$('.news_edit_save').click(function(){
    			$('#edit_form').submit();
    			$('#modal-edit').modal('hide');
    		})
    		$('#edit_form').submit(function(){
    			var data = {};
    			var edit_data = $('#edit_form').serializeArray();
    			edit_data.push({name:"content",value:tinymce.activeEditor.getContent()});
    			$.post('{{ asset("admin/news_edit")}}',edit_data,'json');
    			swal(
					'更新成功！',
					'最新消息資料已更新。',
					'success'
				);
				news_list(data);
    			return false;
    		});
		})
	}
</script>
@endpush