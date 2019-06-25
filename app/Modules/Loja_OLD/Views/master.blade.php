<!DOCTYPE html>
<html lang="pt">
  
  <head>
      <title> @yield('title') | Multiply School</title>
      @include('Loja::templates.head')
      @yield('css')
  </head>
  
  <body> 
  <?php $info = session()->get('lojaInfo'); ?>
  <div class="load" > <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> </div>

  <?php session()->put("teste", array('name'=>'Testando'));  ?>

   	@include('Loja::templates.header')
	   	
   	@yield('content')

    @include('Loja::templates.footer')

    @include('Loja::templates.modals')

    @yield("scripts")

  </body>
</html>