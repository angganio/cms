@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
    
    <div class="control-group">
    {!! Form::label('txt_artid',  'Article ID', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_artid', isset($art)?$art->id_artikel:'', array('class' => 'span8','readonly' => 'readonly')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
     <div class="control-group">
    {!! Form::label('txt_title',  'Title', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_title', isset($art)?$art->title:'', array('class' => 'span8','maxlength' => '100')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
     <div class="control-group">
    {!! Form::label('cb_cat', 'Category', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::select('cb_cat',$cb_cat,isset($art)?$art->catid:'',array('class' => 'span8')); !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
      <div class="control-group">
    {!! Form::label('txt_thumb', 'Thumbnail', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::file('txt_thumb', '', array('class' => 'filestyle')) !!}
        {!! Form::hidden('txt_thumb_old', isset($art)?$art->thumb :'') !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
        <div class="controls"> 
        	<div class="stream-attachment photo">
				<div class="responsive-photo">
					<img id="thumb" alt="Thumbnail" src="{{isset($art)?asset($art->thumb):''}}" />
                  </div>
                </div>
        <span class="help-inline"></span>
        </div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_summ',  'Summary', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::textarea('txt_summ', isset($art)?$art->summary:'', array('class' => 'span8','cols' => '200','rows' => '5','style' => 'width: 550px; height: 150px')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_content',  'Content', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::textarea('txt_content', isset($art)?$art->content:'', array('class' => 'span8','cols' => '200','rows' => '10','style' => 'width: 550px; height: 500px')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_galleryid',  'ID Gallery', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_galleryid', isset($art)?$art->id_gallery:'', array('class' => 'span8','maxlength' => '10')) !!}
		<span class="help-inline">Separated with commas</span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_tag',  'Tag', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_tag', isset($art)?$art->tag:'', array('class' => 'span8','maxlength' => '100')) !!}
		<span class="help-inline">Separated with commas</span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('cb_status', 'Status', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::select('cb_status', $status,isset($art)?$art->status:'',array('class' => 'span8')); !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
		<div class="controls">
         <a class="btn btn-danger" href="{{ asset('art') }}">Cancel</a>&nbsp;
       {!! Form::submit($button_name,array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
    
    {!! Form::close() !!}	
@endsection
@section('other')
<script type="application/javascript" src="{{asset("public/bootstrap_plugin/bootstrap-filestyle.min.js")}}"></script>
 <script>
$(":file").filestyle({input: false,buttonText: "Choose Thumbnail"});
</script>
<script>
 function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumb').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#txt_thumb").change(function(){
        readURL(this);
    });
</script>
<script src="{{asset("public/bootstrap_plugin/TinyMCE 4.2.5/js/tinymce/tinymce.min.js")}}" type="text/javascript"></script>
<script type="text/javascript">
        tinymce.init({
            selector: "#txt_summ",
			 plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
        });
    </script>
    <script type="text/javascript">
        tinymce.init({
            selector: "#txt_content",
			 plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
        });
    </script>
@endsection
