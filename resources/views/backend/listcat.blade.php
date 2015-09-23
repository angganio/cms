@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
      <div class="btn-group pull-right" data-toggle="buttons-radio">
      <a href="<?php echo url('/cat/addCat'); ?>" class="btn btn-primary"><i class="menu-icon icon-plus"></i> Create Category</a>
      </div>
      <br />
      <br />
      <table id="cat" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID Cat</th>
						<th>Description</th>
						<th>Status</th>
                        <th>Options</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th>ID Cat</th>
						<th>Description</th>
						<th>Status</th>
						<th>Options</th>
					</tr>
				</tfoot>  
 <tbody>
 <?php foreach($cat as $row): ?>
 <tr>
 	<td>
    <?php echo $row->catid; ?>
 	</td>
    <td>
    <?php echo $row->desc; ?>
 	</td>
    <td align="center">
    <?php echo $row->status; ?>
 	</td>
    <td>
    <div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo asset('cat/editCat').'/'.$row->catid; ?>"><i class="menu-icon icon-edit"></i> Edit</a></li>
    <li><a title="Delete Category <?php echo $row->catid; ?> - <?php echo $row->desc; ?>" href="<?php echo asset('cat/delCat').'/'.$row->catid; ?>" id="confirm"><i class="menu-icon icon-trash"></i> Delete</a></li>
  </ul>
</div>
    </td>
 </tr>
 <?php endforeach; ?>
 </tbody>
 </table>                       
@endsection
@section('other')
<link rel="stylesheet" type="text/css" href="{{asset("public/bootstrap_plugin/DataTables-1.10.9/media/css/jquery.dataTables.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset("public/bootstrap_plugin/DataTables-1.10.9/examples/resources/syntax/shCore.css")}}">
<style type="text/css" class="init">

</style>
<script type="text/javascript" language="javascript" src="{{asset("public/bootstrap_plugin/DataTables-1.10.9/media/js/jquery.dataTables.js")}}"></script>
<script type="text/javascript" language="javascript" src="{{asset("public/bootstrap_plugin/DataTables-1.10.9/examples/resources/syntax/shCore.js")}}"></script>
  <script type="text/javascript" class="init">
$(document).ready(function() {
    $('#cat').DataTable({
  "columnDefs": [
    { "orderable": false, "targets": 3 }
  ]
});
} );
</script>  
<script src="{{asset("public/bootstrap_plugin/bootbox.min.js")}}" type="text/javascript"></script>
    <script>
$("a#confirm").click(function(e) {
	var url = $(this).attr('href');
	var title = $(this).attr('title');
	e.preventDefault();
	
	bootbox.confirm("Are you sure want to "+title+" ?", function(result) {
		if(result)
		{
			location.href=url;
		}
	}); 
 
});
    </script>
@endsection
