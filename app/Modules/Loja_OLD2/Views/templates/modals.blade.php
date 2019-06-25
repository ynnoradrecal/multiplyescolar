{{-- <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLogin">
	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
			</div>

		    <div class="modal-body noppading">
		    	<div class="global-login ">
		    		<img src="{{ asset('images') }}/logo-login.png" class="center-block" />
			    	<div class="col-md-10 col-md-offset-1">
				    	<div class="login-container center-block">
			    			{!! Form::open(['id'=>'loginForm','route' => 'login.cliente', 'method' => 'post']) !!}
			    					
								@if( isset($errors) && count($errors) > 0)
					                <div class="alert alert-danger" role="alert">
						                <ul>
						                  @foreach ($errors->all() as $error)
						                    <li>{{ $error }}</li>
						                  @endforeach
						                </ul>
					                </div>
					             @endif                

					            <div class="form-group-lg">
					                <label>Nome do usuário</label>
					                {!! Form::email('email', $value = null, ['class'=>'form-control']) !!}
					                <br>
					            </div>
					            <div class="form-group-lg">
					                  <label>Senha</label>
					                  {!! Form::password('password', ['class'=>'form-control']) !!}
					                  <br>
					            </div>
					            <div class="form-group text-center">
					                 <a href="#" class="modal-reset-pass">Esqueceu a senha?</a> | 
					                 <a href="#" class="modal-cadastro" >Não possuo cadastro.</a>
					            </div>
					            <div class="form-group">
					                  {!! Form::submit('Fazer login', ['class'=>'btn btn-lg btn-success btn-block']) !!}                  
					            </div>
			            	{!! Form::close() !!}
			          	</div>
			        </div>
			        <div class="clearfix"></div>
		        </div>
		        
	        </div>
	    </div>
	</div>
</div>


<div class="modal fade" id="modalResetPass" tabindex="-1" role="dialog" aria-labelledby="modalResetPass">
	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
			</div>

		    <div class="modal-body noppading">
		    	<div class="global-login ">
		    		<img src="{{ asset('images') }}/logo-login.png" class="center-block" />
			    	<div class="col-md-10 col-md-offset-1">
				    	<div class="login-container center-block">
			    			{!! Form::open(['id'=>'resetPass','route' => 'login.cliente', 'method' => 'post']) !!}
			    					
								@if( isset($errors) && count($errors) > 0)
					                <div class="alert alert-danger" role="alert">
						                <ul>
						                  @foreach ($errors->all() as $error)
						                    <li>{{ $error }}</li>
						                  @endforeach
						                </ul>
					                </div>
					             @endif                

					            <div class="form-group-lg">
					                <label>Email do usuário</label>
					                {!! Form::email('email', $value = null, ['class'=>'form-control']) !!}
					                <br>
					            </div>
					            <div class="form-group">
					           		<a href="#" class="voltar-login">Realizar Login</a>
					           	</div>
					            <div class="form-group">
					                  {!! Form::submit('Enviar', ['class'=>'btn btn-lg btn-success btn-block']) !!}                  
					            </div>
			            	{!! Form::close() !!}
			          	</div>
			        </div>
			        <div class="clearfix"></div>
		        </div>
		        
	        </div>
	    </div>
	</div>
</div>


<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalCadastro">
	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
			</div>

		    <div class="modal-body noppading">
		    	<div class="global-login ">
		    		<img src="{{ asset('images') }}/logo-login.png" class="center-block" />
			    	<div class="col-md-10 col-md-offset-1">
				    	<div class="login-container center-block">
			    			<h1>Cadastro</h1>

					    	@if( isset($errors) && count($errors) > 0)
					    		<div class="alert alert-danger" role="alert">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
					    		</div>
					    	@endif

					    	<form method="POST" action="cadastro" accept-charset="UTF-8">
					    		<input name="_token" type="hidden" value="{{ Session::token() }}">
								
								<div class="form-group">
						            <input id="first" class="form-control" placeholder="Nome" name="nome" type="text">
						        </div>

						        <div class="form-group">
						            <input id="sobrenome" class="form-control" placeholder="Sobrenome" name="sobrenome" type="text">
						        </div>

						        <div class="form-group">
						            <select id="sexo" class="form-control" name="sexo"><option selected="selected" value="">Sexo</option><option value="M">Masculino</option><option value="F">Feminino</option></select>
						        </div>

						      	<div class="form-group">
						            <input id="email" class="form-control" placeholder="Email" name="email" type="email">
						        </div>		        

						        <div class="form-group">
						            <input class="form-control" placeholder="Senha" name="pass" value="" type="password">
						        </div>

						        <div class="form-group">
					                 <a href="#" class="ja-sou-cadastrado" >Já sou cadastrado!</a>
					            </div>

						        <div class="form-group">
						            <input class="btn btn-lg btn-success" value="Cadastrar" type="submit">
						        </div>
						    </form>
			          	</div>
			        </div>
			        <div class="clearfix"></div>
		        </div>
		        
	        </div>
	    </div>
	</div>
</div> --}}

<div class="modal fade" id="modalAddComent" tabindex="-1" role="dialog" aria-labelledby="modalAddComent">
	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
			<div class="modal-header">				
				<a href="#" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
				<h4>Adicione um comentário a foto.</h4>
			</div>

			<form id="addComent" method="POST">
		    	<div class="modal-body">				
					<textarea name="comment" id="comment" cols="30" rows="10" placeholder="Digite seu comentário..." ></textarea><br>
					<a href="javascript:void(0)" id="btnAdicionar" class="btn btn-blue pull-left">Adicionar</a>
					<div class="clearfix"></div>			
	        	</div>
				{{-- <div class="modal-footer">
					
				</div> --}}
			</form>
	    </div>
	</div>
</div>