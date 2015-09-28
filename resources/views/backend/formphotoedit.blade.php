@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
    <div class="control-group">
    {!! Form::label('txt_id_item',  'ID Item', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_id_item', isset($photo)?$photo->id_item:'', array('class' => 'span8','readonly' => 'readonly')) !!}
            {!! Form::hidden('txt_idgallery', isset($photo)?$photo->id_gallery:'') !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_caption', 'Caption', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::text('txt_caption', isset($photo)?$photo->caption:'', array('class' => 'span8','maxlength' => '255')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    

    <div class="control-group">
		<div class="controls">
         <a class="btn btn-danger" href="{{ asset('gallery/addPhoto/').'/'.$photo->id_gallery }}">Cancel</a>&nbsp;
       {!! Form::submit($button_name,array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
    
    {!! Form::close() !!}	
@endsection
@section('other')
@endsection