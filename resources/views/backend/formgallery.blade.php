@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
    <div class="control-group">
    {!! Form::label('txt_idgallery',  'ID Gallery', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_idgallery', isset($gallery)?$gallery->id_gallery:'', array('class' => 'span8','readonly' => 'readonly')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_name', 'Description', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::text('txt_name', isset($gallery)?$gallery->name:'', array('class' => 'span8','maxlength' => '200')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
		<div class="controls">
         <a class="btn btn-danger" href="{{ asset('gallery') }}">Cancel</a>&nbsp;
       {!! Form::submit($button_name,array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
    
    {!! Form::close() !!}	
@endsection
@section('other')
@endsection