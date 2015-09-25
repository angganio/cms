@extends('backend.master')
@section('title', $title)
@section('page_title', $page_title)
@section('content')
    {!! Form::open(['url' => $url, 'method' => 'post', 'class' => 'form-horizontal row-fluid','files' => true]) !!}
    <div class="control-group">
    {!! Form::label('txt_code',  'Status Code', array('class' => 'control-label')) !!}
		<div class="controls">
         @if(isset($status))
    		{!! Form::text('txt_code', isset($status)?$status->code:'', array('class' => 'span8','readonly' => 'readonly')) !!}
         @else
         	{!! Form::text('txt_code', isset($status)?$status->code:'', array('class' => 'span8')) !!}
         @endif
		<span class="help-inline"></span>
		</div>
	</div>
    
    <div class="control-group">
    {!! Form::label('txt_desc', 'Description', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::text('txt_desc', isset($status)?$status->desc:'', array('class' => 'span8','maxlength' => '100')) !!}
		<span class="help-inline"></span>
		</div>
	</div>

     <div class="control-group">
    {!! Form::label('txt_color', 'Color', array('class' => 'control-label')) !!}
		<div class="controls">
    	{!! Form::text('txt_color', isset($status)?$status->color:'', array('class' => 'span8','maxlength' => '100')) !!}
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
<script type="application/javascript" src="{{asset("public/bootstrap_plugin/tinyColorPicker-master/jqColorPicker.min.js")}}"></script>

@endsection