@section('commodity_edit_modal')
{{-- 修改功能Start --}}
<div class="modal fade" id="modal-commodity-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">編輯商品</h4>
			</div>
			<div class="modal-body">
				<form id="edit_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-2 control-label">商品名稱</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">價錢</label>
							<div class="col-sm-10">
								<input type="text" name="price" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">敘述</label>
							<div class="col-sm-10">
								<textarea required="required" class="form-control" name="description"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">備註</label>
							<div class="col-sm-10">
								<textarea required="required" class="form-control" name="remark"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">圖片</label>
							<div class="col-sm-10">
								<div class="img_content" style="overflow-y:auto;overflow-x:hidden;height:170px;width:auto;">
									
								</div>
								<input type="file" multiple accept="image/*" name="img[]" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">狀態</label>
							<div class="col-sm-10">
								<select name="status" class="form-control">
									<option value="" selected="selected">請選擇</option>
									<option value="1">啟用</option>
									<option value="0">停用</option>
								</select>
							</div>
						</div>
						<input type="hidden" name="category_id" value="">
						<input type="hidden" name="id" value="">
					</div>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{-- 修改功能End --}}
@endsection
@push('script')
<script type="text/javascript">
	
	function commodity_edit(){
		$('.commodity_edit').click(function(){
			$('#modal-commodity-edit').modal('show');
			$('#modal-commodity-edit').on('hidden.bs.modal',function(){
				document.getElementById('edit_form').reset();
			});
			var edit_id = $(this).attr('data-id');
			modal_val(edit_id);
		})
	}

	function modal_val(edit_id){
		$('.img_content').html('');
		$.post('{{ asset('admin/get_commodity_edit_data') }}',{ id : edit_id , _token : '{{ csrf_token() }}' },function(res){
				var edit_name = res.data.name;
				var edit_price = res.data.price;
				var edit_description = res.data.description;
				var edit_remark = res.data.remark;
				var edit_status = res.data.status;
				var edit_category_id = res.data.category_id;
				$('#edit_form [name=id]').val(edit_id);
				$('#edit_form [name=name]').val(edit_name);
				$('#edit_form [name=price]').val(edit_price);
				$('#edit_form [name=description]').val(edit_description);
				$('#edit_form [name=remark]').val(edit_remark);
				$('#edit_form [name=status]').val(edit_status);
				$('#edit_form [name=category_id]').val(edit_category_id);
				$.each(res.img,function(k,v){
					$('.img_content').append('<div style="height:150px;width:150px;display:inline-block;text-align:center;">\
												<img src="/'+v.img+'" style="height:100px;width:100px;">\
												<div class="delete_images btn btn-danger" data-id="'+res.data.id+'" data-img-id="'+v.id+'">刪除</div>\
											  </div>');
				})
				delete_images();
			},'json');
	}

	$('#edit_form').submit(function(){
		var edit_data = new FormData(this);
		$.ajax({
			type:"POST",
			url:'{{ asset("admin/edit_commodity")}}',
			dataType:'json',
			data:edit_data,
			async: false,
			cache: false,
			processData: false,
			contentType: false,
			success: function (e) {
				swal(
					e.message,
					'商品資訊已更新。',
					e.in
				);
				$('#modal-commodity-edit').modal('hide');
			}
		})
		commodity_list();
		return false;
	});

	function delete_images(){
		$('.delete_images').click(function(){
			var edit_id = $(this).attr('data-id');
			var delete_id = $(this).attr('data-img-id');
			$.post('{{ asset('admin/delete_images') }}',{ id : delete_id , _token : '{{ csrf_token() }}'},'json');
			setTimeout(function(){ modal_val(edit_id); }, 500);
		})
	}
</script>
@endpush