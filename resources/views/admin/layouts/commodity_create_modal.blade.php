@section('commodity_create_modal')
{{-- 新增功能Start --}}
<div class="modal fade" id="modal-commodity-create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">新增商品</h4>
			</div>
			<div class="modal-body">
				<form id="create_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-2 control-label">商品名稱</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" required="required" placeholder="請輸入商品名稱">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">價錢</label>
							<div class="col-sm-10">
								<input type="text" name="price" class="form-control" required="required" placeholder="請輸入商品價錢">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">敘述</label>
							<div class="col-sm-10">
								<textarea required="required" class="form-control" name="description" placeholder="請輸入商品敘述"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">備註</label>
							<div class="col-sm-10">
								<textarea required="required" class="form-control" name="remark" placeholder="請輸入商品備註"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">圖片</label>
							<div class="col-sm-10">
								<input type="file" multiple accept="image/*" name="img[]" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">狀態</label>
							<div class="col-sm-10">
								<select name="status" class="form-control">
									<option value="1" selected="selected">啟用</option>
									<option value="0">停用</option>
								</select>
							</div>
						</div>
						<input type="hidden" name="category_id" value="">
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
	
	function commodity_create(){
		$('.commodity_create').click(function(){
			var category_id = $(this).attr('data-id');
			$('input[name=category_id]').val(category_id);
			$('#modal-commodity-create').modal('show');
			$('#modal-commodity-create').on('hidden.bs.modal',function(){
				document.getElementById('create_form').reset();
			});
		})
	}

	$('#create_form').submit(function(){
		var insert_data = new FormData(this);
		$.ajax({
			type:"POST",
			url:'{{ asset("admin/insert_commodity")}}',
			dataType:'json',
			data:insert_data,
			async: false,
			cache: false,
			processData: false,
			contentType: false,
			success: function (e) {
				swal(
					e.message,
					'已新增商品。',
					e.in
				);
				$('#modal-commodity-create').modal('hide');
			}
		})
		commodity_list();
		return false;
	});
</script>
@endpush