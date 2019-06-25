<!DOCTYPE html>
<html lang="pt">
  
  <head>
      <title> @yield('title') | Multiply School</title>
      @include('Beta::templates.head')
      @yield('css')
  </head>
  
  <body> 
  <?php $info = session()->get('lojaInfo'); ?>
  <div class="load" > <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> </div>

  <?php session()->put("teste", array('name'=>'Testando'));  ?>

   	@include('Beta::templates.header')
	   	
   	@yield('content')

    @include('Beta::templates.footer')

    @include('Beta::templates.modals')

    @yield("scripts")

  </body>
</html>