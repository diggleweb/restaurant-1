<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') {{Config::get('constant.site.name')}}</title>

	<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css"> -->
	<link href="{{ asset('/css/bootstrap-flat-custom.min.css') }}" rel="stylesheet">
	
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('style-top')
	<link href="{{ asset('/css/admin-style.css') }}" rel="stylesheet">
</head>
<body>
	<div id="admin-sidebar">
		<div class="admin-site-logo">
			<img src="{{ asset(Config::get('constant.site.logo'))}}" class="img-responsive" alt="">
		</div>
		<center>
			<div class="btn-group">
				<a href="#" class="btn btn-primary btn-sm">
					<i class="glyphicon glyphicon-cog"></i>
				</a>
				<a href="{!! url('/auth/logout') !!}" class="btn btn-danger btn-sm">
					<i class="glyphicon glyphicon-log-out"></i>
				</a>
			</div>
		</center>
		<div class="admin-left-menu">
			@include("common.admin-left-side-menu")
		</div>
	</div>
	<div id="admin-container">
		<header>
			<ul class="tab-nav">
				<li class="lead pull-left"><a href="">@yield('title')</a></li>
	            @yield('top-menu')
	        </ul>
			@include('flash::message')
			@yield('breadcrumbs')
        </header>
		<div class="container-fluid">
			@yield('content')
		</div>
		<footer>
			<center>
				<strong>Powered by <a href="#" target="_blank">{{Config::get('constant.site.name')}}</a></strong>
			</center>
		</footer>
	</div>
	<!-- Scripts -->
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script> -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/admin.script.js') }}"></script>
	<script>
		//This is only necessary if you do Flash::overlay('...')
		$(function(){
			$('#flash-overlay-modal').modal();
			$(".btn-radio>label.btn>input[type='radio']:checked").parent().addClass("active");
		});
	</script>
	@yield('script-bottom')
</body>
</html>