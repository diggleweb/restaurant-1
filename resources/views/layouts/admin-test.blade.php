<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{Config::get('constant.site.name')}}</title>

	<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css"> -->
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- <link href="{{ asset('/css/app.min.1.css') }}" rel="stylesheet"> -->
	<link href="{{ asset('/css/admin-style.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	@include("common.admin-left-side-menu")
	@include('flash::message')
	<div id="admin-container" class="container-fluid">
		@yield('content')
	</div>
	<footer>
		<center>
			<strong>Powered by <a href="#" target="_blank">{{Config::get('constant.site.name')}}</a></strong>
		</center>
	</footer>
	<!-- Scripts -->
	<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script> -->
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script>
		//This is only necessary if you do Flash::overlay('...')
		$(function(){
			$("#left-side-menu .")
		});
	    $('#flash-overlay-modal').modal();
	</script>
</body>
</html>