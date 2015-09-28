@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
      <div class="btn-group pull-right" data-toggle="buttons-radio">
     <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="menu-icon icon-plus"></i> Upload Photo</a>
      </div>
      <br />
      <br />
      <table id="gallery" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID Item</th>
						<th class="nosort">Photo</th>
                        <th>Caption</th>
                        <th class="nosort">Options</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th>ID Item</th>
						<th class="nosort">Photo</th>
                        <th>Caption</th>
						<th class="nosort">Options</th>
					</tr>
				</tfoot>  
 <tbody>
 <?php foreach($gallery_item as $row): ?>
 <tr>
 	<td>
    <?php echo $row->id_item; ?>
 	</td>
    <td>
   <div id="<?php echo $row->id_item; ?>" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
	<div class='lightbox-content'>
		<img src="<?php echo asset($row->foto); ?>">
		<div class="lightbox-caption"><p><?php echo $row->caption; ?></p></div>
	</div>
</div><a class="thumbnail" data-toggle="lightbox" href="#<?php echo $row->id_item; ?>">
     <img src="<?php echo asset($row->foto); ?>" style="width:100px; height:100px;" />
    </a>
 	</td>
    <td>
    <?php echo $row->caption; ?>
 	</td>
    <td>
    <div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo asset('gallery/editPhoto').'/'.$row->id_gallery.'/'.$row->id_item; ?>"><i class="menu-icon icon-edit"></i> Edit</a></li>
    <li><a title="Delete Item <?php echo $row->id_item; ?> - <?php echo $row->caption; ?>" href="<?php echo asset('gallery/delPhoto').'/'.$row->id_gallery.'/'.$row->id_item; ?>" id="confirm"><i class="menu-icon icon-trash"></i> Delete</a></li>
  </ul>
</div>
    </td>
 </tr>
 <?php endforeach; ?>
 </tbody>
 </table>    
  <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <input type="hidden" name="txt_idgallery" value="<?php echo Request::segment(3); ?>">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Photo</h4>
      </div>
      <div class="modal-body">
      
        <div class="control-group">
       Photo: <input type="file" class="filestyle"  name="txt_userfile" id="txt_userfile">
        </div>
        <div class="control-group">
         <div class="stream-attachment photo">
			<div class="responsive-photo">
<img id="photo" alt="Photo" />
                  </div>
                  </div>
        </div>
         <div class="control-group">
		Caption: <input name="txt_caption" type="text" class="span8" id="txt_caption" style="width:500px">
		</div>
      </div>
      
     
                                        
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
    {!! Form::close() !!}	
</div>                   
@endsection
@section('other')
<link rel="stylesheet" type="text/css" href="{{asset("public/bootstrap_plugin/DataTables-1.10.9/media/css/jquery.dataTables.css")}}">
<link rel="stylesheet" type="text/css" href="{{asset("public/bootstrap_plugin/DataTables-1.10.9/examples/resources/syntax/shCore.css")}}">
<link type="text/css" href="{{asset("public/bootstrap_plugin/bootstrap-lightbox/bootstrap-lightbox.min.css")}}" rel="stylesheet">
<style type="text/css" class="init">

</style>
<script type="text/javascript" language="javascript" src="{{asset("public/bootstrap_plugin/DataTables-1.10.9/media/js/jquery.dataTables.js")}}"></script>
<script type="text/javascript" language="javascript" src="{{asset("public/bootstrap_plugin/DataTables-1.10.9/examples/resources/syntax/shCore.js")}}"></script>
  <script type="text/javascript" class="init">
$(document).ready(function() {
    $('#gallery').DataTable({
  "columnDefs": [
    { "orderable": false, "targets": 'nosort' }
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

 <script src="{{asset("public/bootstrap_plugin/bootstrap-lightbox/bootstrap-lightbox.min.js")}}" type="text/javascript"></script>
 
<script src="{{asset("public/bootstrap_plugin/bootstrap-filestyle.min.js")}}" type="text/javascript"></script>
<script>
$(":file").filestyle({input: false,buttonText: "Choose Photos"});
</script>
<script>
 function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#photo').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#txt_userfile").change(function(){
        readURL(this);
    });
</script>
@endsection
