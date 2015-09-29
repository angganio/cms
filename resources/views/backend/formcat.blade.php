@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
    <div class="control-group">
    {!! Form::label('txt_catid',  'Cat ID', array('class' => 'control-label')) !!}
		<div class="controls">
    		{!! Form::text('txt_catid', isset($cat)?$cat->catid:'', array('class' => 'span8','readonly' => 'readonly')) !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
     <div class="control-group">
    {!! Form::label('cb_parent', 'Parent', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::select('cb_parent',$cb_parent,isset($cat)?$cat->pid:'',array('class' => 'span8')); !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_desc', 'Description', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::text('txt_desc', isset($cat)?$cat->desc:'', array('class' => 'span8','maxlength' => '50')) !!}
		<span class="help-inline"></span>
		</div>
	</div>

    <div class="control-group">
    {!! Form::label('cb_status', 'Status', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::select('cb_status', $status,isset($cat)?$cat->status:'',array('class' => 'span8')); !!}
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
		<div class="controls">
         <a class="btn btn-danger" href="{{ asset('cat') }}">Cancel</a>&nbsp;
       {!! Form::submit($button_name,array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
    
    {!! Form::close() !!}	
@endsection
@section('other')
@endsection