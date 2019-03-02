@extends('admin.layouts.main')
@include('admin.layouts.main_category_create_modal')
@include('admin.layouts.main_category_edit_modal')
@include('admin.layouts.sub_category_create_modal')
@include('admin.layouts.sub_category_edit_modal')
@yield('main_create_modal')
@yield('main_edit_modal')
@yield('sub_create_modal')
@yield('sub_edit_modal')
@section('page_content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>商品分類列表<small>Commodity Category</small></h2>
			<button class="btn btn-primary main_create" type="button" data-toggle="modal">新增大分類</button>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-12 category_list">
			
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">

	category_list();

	function category_list(){
		var category_list_data = '';
		$.get('{{ asset('admin/get_commodity_category') }}',function(res){
			$.each(res,function(key,value){
				category_list_data  +=  '<div class="x_panel">'+
											'<div class="x_title">'+
												'<h2>'+value.title+'</h2>'+
												'<button class="btn btn-primary sub_create" type="button" data-toggle="modal" data-id="'+value.id+'">新增子類別</button>'+
												'<button class="btn btn-success main_edit" type="button" data-toggle="modal" data-target="#modal-main-edit" data-id="'+value.id+'">編輯名稱</button>'+
												'<div class="clearfix"></div>'+
											'</div>'+
											'<div class="x_content">'+
												'<table class="table">'+
													'<thead>'+
														'<tr>'+
															'<th>#</th>'+
															'<th>子類別</th>'+
															'<th>操作</th>'+
														'</tr>'+
													'</thead>'+
													'<tbody>';
													var sub_count = 1;
													$.each(value.sub_items,function(k,v){
														category_list_data  +=  '<tr>'+
																					'<th scope="row">'+sub_count+'</th>'+
																					'<td>'+v.title+'</td>'+
																					'<td>'+
																						'<button type="button" class="btn btn-success sub_edit" data-toggle="modal" data-target="#modal-sub-edit" data-id="'+v.id+'">修改</button>'+
																						'<button type="button" class="btn btn-danger sub_delete" data-id="'+v.id+'">刪除</button>'+
																					'</td>'+
																				'</tr>';
														sub_count++;
													})
													category_list_data += '</tbody>'+
												'</table>'+
											'</div>'+
										'</div>';
			});
			$('.category_list').html(category_list_data);
			main_create();
			main_edit();
			sub_create();
			sub_edit();
			sub_delete();
		});
	}

	function sub_delete(){
		$('.sub_delete').click(function(){
			var delete_id = $(this).attr('data-id');
			swal({
				title : '確定刪除此分類嗎？',
				text : '刪除將無法恢復！',
				type: 'warning',
				showCancelButton: true, 
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '確定刪除！',
				cancelButtonText: '取消刪除！',
			}).then(function(e) {
				if(e.value){
					$.post('{{ asset('admin/commodity_category_delete') }}',{ id : delete_id , _token : '{{ csrf_token() }}'},'json');
					swal(
						'已刪除！',
						'該分類已被刪除。',
						'success'
					);
					setTimeout(function(){ category_list(); }, 500);
				}
			})
		})
	}
</script>
@endpush