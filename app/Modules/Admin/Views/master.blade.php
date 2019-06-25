<!DOCTYPE html>
<html lang="pt">

@include('Admin::template.head') <!-- head -->

@if ( $login != 0 )
<body class="nav-md app"> 
	<div class="container body">
		<div class="main_container">
@else
<body class="login">
	<div id="app">
@endif

@if ( $login != 0 )
	@include('Admin::template.sidenav')
@endif

@if ( $login != 0 )
		<div id="app" class="right_col" role="main">
@endif

@yield('content')

@if ( $login != 0 )
			</div>
			@include('Admin::template.footer')
		</div>
	</div>
@else
	</div>
@endif

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script> -->

	<script src="{{ asset('js/componentes.js') }}" ></script>
	<script src="{{ asset('js/admin.js') }}" ></script>

</body>
</html>
