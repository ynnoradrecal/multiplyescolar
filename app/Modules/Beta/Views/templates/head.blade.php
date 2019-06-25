

    
    <meta name="description" content="This is a free Bootstrap landing page theme created for BootstrapZero. Feature video background and one page design." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Codeply">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url-app" content="{{ url('/') }}">
    
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/store.css') }}" rel="stylesheet">

    

    <!-- Bootstrap core CSS -->    

    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

     @if( last(explode('/', url()->full())) == 'checkout' )
    <!-- <script type="text/javascript" 
        src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
    </script> -->
    <script type="text/javascript" src="{{ url('/pagseguro/javascript') }}"></script>
    <!-- <script src="{{ url('/pagseguro/javascript') }}"></script> -->
    @endif



