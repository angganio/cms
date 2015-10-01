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
						<th class="nosort">Images</th>
                        <th class="nosort">Images URL</th>
                        <th class="nosort">Options</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th class="nosort">Images</th>
                        <th class="nosort">Images URL</th>
                        <th class="nosort">Options</th>
					</tr>
				</tfoot>  
 <tbody>
 <?php 
  $i = 0;
 foreach($files as $file => $value):
 
 $filename = $value['dirname'].'/'.$value['basename'];
 $i = $i + 1; ?>
 <tr>
    <td>
   <div id="<?php echo  $i; ?>" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
	<div class='lightbox-content'>
		<img src="<?php echo asset($filename); ?>">
		<div class="lightbox-caption"><p><?php echo $filename; ?></p></div>
	</div>
</div><a class="thumbnail" data-toggle="lightbox" href="#<?php echo  $i; ?>">
     <img src="<?php echo asset($filename); ?>" style="width:100px; height:100px;" />
    </a>
 	</td>
    <td>
    <?php echo asset($filename); ?>
 	</td>
    <td>
    <div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a title="Delete File <?php echo $value['basename']; ?>" href="<?php echo asset('upload/delFile').'/'.$value['basename']; ?>" id="confirm"><i class="menu-icon icon-trash"></i> Delete</a></li>
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
