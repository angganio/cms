@include('backend.header')
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
						<li><a href="{{ url('/user/loginUser') }}">
							Sign In
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
              
               @if(Session::has('status'))
               <div class="alert alert-success">
                {!! Form::button('x',array('class' => 'close', 'data-dismiss' => 'alert')) !!}
                 {{ Session::get('status') }}
               </div>
               @endif
               
				<div class="module module-login span4 offset4">
                  {!! Form::open(['url' => '/password/reset', 'method' => 'post', 'class' => 'form-vertical']) !!}
						<div class="module-head">
							<h3>Please Fill Information Below</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
                                {!! Form::hidden('token', $token) !!}
                                {!! Form::text('email', old('email'), array('class' => 'span12','placeholder' => 'Email Address')) !!}
								</div>
							</div>
                            <div class="control-group">
								<div class="controls row-fluid">
                                {!! Form::password('password', array('class' => 'span12','placeholder' => 'Password')) !!}
								</div>
							</div>
                            <div class="control-group">
								<div class="controls row-fluid">
                                 {!! Form::password('password_confirmation', array('class' => 'span12','placeholder' => 'Confirm Password')) !!}
								</div>
							</div>
							
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
                                 {!! Form::submit('Reset Password',array('class' => 'btn btn-primary pull-right')) !!}
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
@include('backend.footer')