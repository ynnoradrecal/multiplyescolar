
<div class="container">
    <div class="col-md-4 col-md-offset-4">

	    <div class="form-cad"> 
	    	

	    	<h1>Usuário Logado</h1>
	    {!!  Auth::guard('cliente')->user()->name !!} {!! Auth::guard('cliente')->user()->last_name !!}

	    	
	    </div>
    </div>
</div><!-- /.container -->




   
  

