@extends('admin.layouts.main')
@include('admin.layouts.news_create_modal')
@include('admin.layouts.news_edit_modal')
@yield('create_modal')
@yield('edit_modal')
@section('page_content')
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>最新消息列表<small>News list</small></h2>
			<button class="btn btn-primary create" type="button" data-toggle="modal">新增最新消息</button>
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
							<th class="column-title">標題 </th>
							<th class="column-title">狀態 </th>
							<th class="column-title">創建時間 </th>
							<th class="column-title">最後更新時間 </th>
							<th class="column-title">操作 </th>
						</tr>
					</thead>
					<tbody class="news_list">
						
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
<!-- tinymce -->
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}"></script>
<script type="text/javascript">
	var data = {};
	news_list(data);
	function news_list(data){
		$.get('{{ asset('admin/get_news_list') }}',data,function(e){
			var news_data = '';
			var sequence = 1;
			$.each(e.data,function(k,v){
				news_data += '<tr class="pointer">';
				news_data += '<td>'+sequence+'</td>';
				news_data += '<td>'+v.title+'</td>';
				if(v.status == 1){
					status = '<span class="label label-success">啟用</span>'
				}else{
					status = '<span class="label label-danger">停用</span>'
				}
				news_data += '<td>'+status+'</td>';
				news_data += '<td>'+v.created_at+'</td>';
				news_data += '<td>'+v.updated_at+'</td>';
				news_data += '<td>\
									<button type="button" class="btn btn-success edit" data-toggle="modal" data-id="'+v.id+'">修改</button>\
									<button type="button" class="btn btn-danger delete" data-id="'+v.id+'">刪除</button>\
								</td>';
				news_data += '</tr>';
				sequence++;
			});
			$('.news_list').html(news_data);
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
			news_create();
			news_edit();
			news_delete();
		});
	}

	function paginate(){
		$('.paginate_button').click(function(){
			var datapage = $(this).data('id');
			var data = {};
			data.page = datapage;
			news_list(data);
		});
	}

	function news_delete(){
		$('.delete').click(function(){
			var data = {};
			var delete_id = $(this).attr('data-id');
			swal({
				title : '確定刪除此筆最新消息嗎？',
				text : '刪除將無法恢復！',
				type: 'warning',
				showCancelButton: true, 
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '確定刪除！',
				cancelButtonText: '取消刪除！',
			}).then(function(e) {
				if(e.value){
					$.post('{{ asset('admin/news_delete') }}',{ id : delete_id , _token : '{{ csrf_token() }}'},'json');
					swal(
						'已刪除！',
						'該筆最新消息已被刪除。',
						'success'
					);
					news_list(data);
				}
			})
		})
	}
	tinymce.init(
		{"selector":"textarea","language":"zh_TW","theme":"modern","skin":"lightgray","plugins":["advlist autolink link lists charmap preview hr","wordcount code fullscreen insertdatetime nonbreaking","save table contextmenu directionality emoticons paste textcolor jbimages"],"toolbar":"undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages | preview fullpage | forecolor backcolor","height" : "250"}
	);
</script>
@endpush