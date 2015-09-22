<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
     <link href="{{asset("public/template/edmin/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
     <link href="{{asset("public/template/edmin/bootstrap/css/bootstrap-responsive.min.css")}}" rel="stylesheet">
     <link href="{{asset("public/template/edmin/css/theme.css")}}" rel="stylesheet">
     <link href="{{asset("public/template/edmin/images/icons/css/font-awesome.css")}}" rel="stylesheet">
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="#">
			  		{{ config('myconfig.app_title') }}
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
					<ul class="nav pull-right">
						<li><a href="{{ url('password/email') }}">
							Forgot your password?
						</a></li>
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->
				
	<div class="wrapper">
		<div class="container">
			<div class="row">
           <!------------------------Validation error------------------------->
                             @if (count($errors) > 0)
                            <div class="alert alert-danger">
                             {!! Form::button('x',array('class' => 'close', 'data-dismiss' => 'alert')) !!}
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
               <!------------------------Display messages------------------------->   
               @if(Session::has('success'))
               <div class="alert alert-success">
                {!! Form::button('x',array('class' => 'close', 'data-dismiss' => 'alert')) !!}
                 {{ Session::get('success') }}
               </div>
               @endif
               
               @if(Session::has('status'))
               <div class="alert alert-success">
                {!! Form::button('x',array('class' => 'close', 'data-dismiss' => 'alert')) !!}
                 {{ Session::get('status') }}
               </div>
               @endif
               
               @if(Session::has('error'))
               <div class="alert alert-error">
                {!! Form::button('x',array('class' => 'close', 'data-dismiss' => 'alert')) !!}
                 {{ Session::get('error') }}
               </div>
               @endif
				<div class="module module-login span4 offset4">
                  {!! Form::open(['url' => 'user/authUser', 'method' => 'post', 'class' => 'form-vertical']) !!}
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
                                {!! Form::text('txt_userid', '', array('class' => 'span12','placeholder' => 'User ID')) !!}
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
                                {!! Form::password('txt_pass', array('class' => 'span12','placeholder' => 'Password')) !!}
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
                                 {!! Form::submit('Login',array('class' => 'btn btn-primary pull-right')) !!}
									<!--<label class="checkbox">
										<input type="checkbox"> Remember me
									</label>-->
								</div>
							</div>
						</div>
					{!! Form::close() !!}	
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->
<div class="footer">
		<div class="container">
			<b class="copyright">&copy; CMS Admin {{ date('Y') }}. Template by Edmin - EGrappler.com </b> All rights reserved.
		</div>
	</div>
    <script type="application/javascript" src="{{asset("public/template/edmin/scripts/jquery-1.9.1.min.js")}}"></script>
    <script type="application/javascript" src="{{asset("public/template/edmin/scripts/jquery-ui-1.10.1.custom.min.js")}}"></script>
    <script type="application/javascript" src="{{asset("public/template/edmin/bootstrap/js/bootstrap.min.js")}}"></script>
    <script type="application/javascript" src="{{asset("public/template/edmin/scripts/common.js")}}"></script>
</body>