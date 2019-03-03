@section('main_create_modal')
{{-- 新增功能Start --}}
<div class="modal fade" id="modal-main-create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">新增大分類</h4>
			</div>
			<div class="modal-body">
				<form id="create_form">
					{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group row">
							<label for="create_title" class="col-sm-2 control-label">類別名稱</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" required="required" placeholder="請輸入類別名稱">
								<input type="hidden" name="level" value="0">
								<input type="hidden" name="up_id" value="0">
							</div>
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
	function main_create(){
		$('.main_create').click(function(){
			$('#modal-main-create').modal('show');
		})
	}

	$('#create_form').submit(function(){
		var insert_data = $('#create_form').serialize();
		$.post('{{ asset("admin/insert_commodity_category")}}',insert_data,'json');
		swal(
			'新增成功！',
			'已新增大類別。',
			'success'
		);
		$('#modal-main-create').modal('hide');
		category_list();
		return false;
	});
</script>
@endpush