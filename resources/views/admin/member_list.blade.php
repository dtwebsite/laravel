@extends('admin.layouts.main')
@section('page_content')
<div class="modal fade" id="modal-edit"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>會員列表<small>Member list</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li>
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li>
					<a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="table-responsive">
				<table class="table table-striped jambo_table bulk_action">
					<thead>
						<tr class="headings">
							<th class="column-title"># </th>
							<th class="column-title">姓名 </th>
							<th class="column-title">信箱 </th>
							<th class="column-title">註冊時間 </th>
							<th class="column-title">最後更新時間 </th>
							<th class="column-title">操作 </th>
						</tr>
					</thead>
					<tbody class="member_list">
						
					</tbody>
				</table>
				<div>
	    			<div class="dataTables_paginate paging_simple_numbers">
			    		<ul class="pagination"></ul>
			    	</div>
			    </div>
			    <div>
    				<div class="list_total" role="status" aria-live="polite"></div>
    			</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
	var data = {};
	member_list(data);
	function member_list(data){
		$.get('{{ asset('admin/get_member_list') }}',data,function(res){
			var member_data = '';
			var sequence = 1;
			$.each(res.data,function(k,v){
				member_data += '<tr class="pointer">';
				member_data += 		'<td>'+sequence+'</td>';
				member_data += 		'<td>'+v.name+'</td>';
				member_data += 		'<td>'+v.email+'</td>';
				member_data += 		'<td>'+v.created_at+'</td>';
				member_data += 		'<td>'+v.updated_at+'</td>';
				member_data += 		'<td>\
										<button type="button" class="btn btn-success edit" data-toggle="modal" data-target="#modal-edit" data-id="'+v.id+'">修改</button>\
										<button type="button" class="btn btn-danger delete" data-id="'+v.id+'">刪除</button>\
									</td>';
				member_data += '</tr>';
				sequence++;
			});
			$('.member_list').html(member_data);
			var previous = e.current_page -1 == 0 ? 'disabled' : 'paginate_button';
			var next = e.current_page == e.last_page ? 'disabled' : 'paginate_button';
			var page = '<li class="previous '+previous+'" data-id="'+(e.current_page-1)+'">\
							<a href="#" data-dt-idx="0" tabindex="0">上一頁</a>\
						</li>';
			for(i=1;i<=e.last_page;i++){
				var nowpage = e.current_page == i ? 'disabled' : 'paginate_button';
				page += '<li class="'+nowpage+'" data-id="'+i+'">'+
				    		'<a href="#" data-dt-idx="'+i+'" tabindex="0">'+i+'</a>'+
				    	'</li>';
			}
			page += '<li class="next '+next+'" data-id="'+(e.current_page+1)+'">\
						<a href="#" data-dt-idx="7" tabindex="0">下一頁</a>\
					</li>';
			$('.pagination').html(page);
			var total='第'+e.from+'至'+e.to+'筆，總共'+e.total+'筆';
			$('.list_total').html(total);
			paginate();
			member_delete();
			member_edit();
		});
	}

	function paginate(){
		$('.paginate_button').click(function(){
			var datapage = $(this).data('id');
			var data = {};
			data.page = datapage;
			member_list(data);
		});
	}

	function member_delete(){
		$('.delete').click(function(){
			var data = {};
			var delete_id = $(this).attr('data-id');
			swal({
				title : '確定刪除此會員嗎？',
				text : '刪除將無法恢復他！',
				type: 'warning',
				showCancelButton: true, 
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '確定刪除！',
				cancelButtonText: '取消刪除！',
			}).then(function(res) {
				if(res.value){
					$.post('{{ asset('admin/member_delete') }}',{ id : delete_id , _token : '{{ csrf_token() }}' },'json');
					swal(
						'已刪除！',
						'該會員已被刪除。',
						'success'
					);
					member_list(data);
				}
			})
		})
	}

	function member_edit(){
		$('.edit').click(function(){
			var edit_name = $(this).parents('tr').find('td').eq(1).text();
			var edit_email = $(this).parents('tr').find('td').eq(2).text();
			var edit_id = $(this).attr('data-id');
			var edit_str =  '<div class="modal-dialog">'+
        				    	'<div class="modal-content">'+
        							'<div class="modal-header">'+
            							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
            								'<span aria-hidden="true">&times;</span>'+
            							'</button>'+
            							'<h4 class="modal-title">編輯內容</h4>'+
          							'</div>'+
        							'<div class="modal-body">'+
            							'<form id="edit_form">'+
											'{{ csrf_field() }}'+
						    				'<div class="box-body">'+
						    					'<div class="form-group row">'+
						    						'<label for="edit_name" class="col-sm-2 control-label">會員名稱</label>'+
													'<div class="col-sm-10">'+
														'<input type="text" name="name" class="form-control" value="'+edit_name+'">'+
													'</div>'+
												'</div>'+
												'<div class="form-group row">'+
													'<label for="edit_email" class="col-sm-2 control-label">會員信箱</label>'+
    												'<div class="col-sm-10">'+
    													'<input type="text" name="email" class="form-control" value="'+edit_email+'">'+
														'<input type="hidden" name="id" value="'+edit_id+'">'+
    												'</div>'+
												'</div>'+
											'</div>'+
										'</form>'+
          							'</div>'+
          							'<div class="modal-footer">'+
		                				'<button type="submit" class="btn btn-primary save">儲存</button>'+
        							'</div>'+
        						'</div>'+
    						'</div>';
    		$('#modal-edit').html(edit_str);
    		$('.save').click(function(){
    			$('#edit_form').submit();
    			$('#modal-edit').modal('hide')
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