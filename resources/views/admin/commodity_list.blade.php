@extends('admin.layouts.main')
@include('admin.layouts.commodity_create_modal')
@include('admin.layouts.commodity_edit_modal')
@yield('commodity_create_modal')
@yield('commodity_edit_modal')
@section('page_content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>商品列表<small>Commodity List</small></h2>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-12 category_list">
			
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">

	commodity_list();

	function commodity_list(){
		var commodity_list_data = '';
		$.get('{{ asset('admin/get_commodity_list') }}',function(res){
			$.each(res,function(key,value){
				commodity_list_data  +=  '<div class="x_panel">'+
											'<div class="x_title">'+
												'<h2>'+value[0].category.title+'</h2>'+
												'<button class="btn btn-primary commodity_create" type="button" data-toggle="modal" data-id="'+key+'">新增商品</button>'+
												'<div class="clearfix"></div>'+
											'</div>'+
											'<div class="x_content">'+
												'<table class="table">'+
													'<thead>'+
														'<tr>'+
															'<th>#</th>'+
															'<th>商品名稱</th>'+
															'<th>價錢</th>'+
															'<th>敘述</th>'+
															'<th>備註</th>'+
															'<th>圖片</th>'+
															'<th>上架時間</th>'+
															'<th>狀態</th>'+
															'<th>操作</th>'+
														'</tr>'+
													'</thead>'+
													'<tbody>';
													var sub_count = 1;
													$.each(value,function(k,v){
														if(k == 0) return;
														commodity_list_data  +=  '<tr>'+
																					'<th scope="row">'+sub_count+'</th>'+
																					'<td>'+v.name+'</td>'+
																					'<td>'+v.price+'</td>'+
																					'<td>'+v.description+'</td>'+
																					'<td>'+v.remark+'</td>'+
																					'<td><div style="overflow-y:auto;overflow-x:hidden;height:150px;width:150px;">';
																					$.each(v.img,function(k1,v1){
																						commodity_list_data+= '<img src="/'+v1+'" style="height:135px;width:135px;">';
																					})
															commodity_list_data  += '</div></td>'+
																					'<td>'+v.created_at+'</td>';
																					if(v.status == 1){
																						status = '<span class="label label-success">啟用</span>'
																					}else{
																						status = '<span class="label label-danger">停用</span>'
																					}
															commodity_list_data  += '<td>'+status+'</td>'+
																					'<td>'+
																						'<button type="button" class="btn btn-success commodity_edit" data-category="'+key+'" data-id="'+v.id+'">修改</button>'+
																						'<button type="button" class="btn btn-danger commodity_delete" data-id="'+v.id+'">刪除</button>'+
																					'</td>'+
																				'</tr>';
														sub_count++;
													})
													commodity_list_data += '</tbody>'+
												'</table>'+
											'</div>'+
										'</div>';
			});
			$('.category_list').html(commodity_list_data);
			commodity_create();
			commodity_edit();
			commodity_delete();
		});
	}

	function commodity_delete(){
		$('.commodity_delete').click(function(){
			var delete_id = $(this).attr('data-id');
			swal({
				title : '確定刪除此商品嗎？',
				text : '刪除將無法恢復！',
				type: 'warning',
				showCancelButton: true, 
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '確定刪除！',
				cancelButtonText: '取消刪除！',
			}).then(function(e) {
				if(e.value){
					$.post('{{ asset('admin/commodity_delete') }}',{ id : delete_id , _token : '{{ csrf_token() }}'},'json');
					swal(
						'已刪除！',
						'該商品已被刪除。',
						'success'
					);
					setTimeout(function(){ commodity_list(); }, 500);
				}
			})
		})
	}
</script>
@endpush