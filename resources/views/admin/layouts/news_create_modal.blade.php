@section('create_modal')
{{-- 新增功能Start --}}
<div class="modal fade" id="modal-create">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">新增最新消息</h4>
			</div>
			<div class="modal-body">
				<form id="create_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="create_title" class="col-sm-1 control-label">標題</label>
							<div class="col-sm-11">
								<input type="text" name="title" class="form-control" required="required" placeholder="請輸入標題">
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
						<label for="create_content" class="col-sm-12 control-label" style="padding:0;">內容</label>
						<div class="form-group" style="margin-top: 30px;">
							<textarea></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary news_create_save">儲存</button>
			</div>
		</div>
	</div>
</div>
{{-- 新增功能End --}}
@endsection
@push('script')
<script type="text/javascript">
	function news_create(){
		$('.create').click(function(){
			$('#modal-create').modal('show');
			$('.news_create_save').click(function(){
				var insert_data = $('#create_form').serializeArray();
				$('#modal-create').modal('hide');
				insert_data.push({name:"content",value:tinymce.activeEditor.getContent()});
				$.post('{{ asset('admin/insert_news') }}',insert_data,'json');
				swal(
					'新增成功！',
					'已新增一則最新消息。',
					'success'
				);
				var data = {};
				news_list(data);
			})
		})
	}
</script>
@endpush