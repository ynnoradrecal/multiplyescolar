	<footer>
	<div class="container">

			<h2 class="text-center">ENTRE EM CONTATO</h2>

		<div class="col-md-2 col-md-offset-1">

			<div class="logos-footer">
		
				<ul>

					<li class="">
						<img src="{{ asset('images') }}/logo-multiply-cursos.png" alt="Logo Multiply" class="img-responsive center-block">
					</li>

					<li class="">
						<img src="{{ asset('images') }}/logo-multiply-formaturas.png" alt="Logo Multiply" class="img-responsive center-block">
					</li>
					<li class="">
						<img src="{{ asset('images') }}/logo-multiply-imagem.png" alt="Logo Multiply" class="img-responsive center-block">
					</li>
					<li class="">
						<img src="{{ asset('images') }}/logo-multiply-producoes.png" alt="Logo Multiply" class="img-responsive center-block">
					</li>

				</ul>
			
			</div>
			
		</div>

		<div class="col-md-3  col-md-offset-1">

			<div class="links-loja">
			
				<ul>
					<li><a href="#">Politica Compra</a></li>
					{{--  <li><a href="#">Politica Venda</a></li>  --}}
					<li><a href="#">Politica Entrega</a></li>
					{{--  <li><a href="#">Politica Segurança</a></li>  --}}
				</ul>

			</div>
		
		</div>

		<div class="col-md-4 ">

			<div class="newslatter">
				<h4 class="">Cadastre-se e Receba Novidades</h4>
				
				<form>
					<div class="row">
						<div class="col-xs-8">
							<div class="form-group">
								<input type="email" name="email" class="form-control" placeholder="Digite seu email!" />
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<input type="submit" class="btn" value="ENVIAR" />
							</div>
						</div>
					</div>
				</form>

				<h4 class="">Métodos de Pagamento</h4>
				<img src="{{ asset('images') }}/cards.png" />
			</div>			
		</div>

		

		</div>

	</div>
	<div class="down-footer">
		<div class="container text-center">
		Todos os direitos reservados {{ date('Y') }} - Privacy Policy
		</div>
	</div>
	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="{{ asset('js/slick.min.js') }}"></script>
	<script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
	<script src="{{ asset('js/store.js') }}"></script>

	<script>
	$(document).ready(function(){

		//setTimeout(function () {
		//	$('.single-item').slick();
		//	// console.log('Foi');
		//}, 1000);

		$('input#nome').focusin(function(){
			$('lable[for="nome"]').animate({'bottom': '43px','font-size':'11px'}, 300);

		}).focusout(function(){
			if($(this).val() == ''){
				$('lable[for="nome"]').animate({'bottom': '24px','font-size':'14px'}, 300);
			}
		});
		
		$('input#email').focusin(function(){
			$('lable[for="email"]').animate({'bottom': '43px','font-size':'11px'}, 300);

		}).focusout(function(){
			if($(this).val() == ''){
				$('lable[for="email"]').animate({'bottom': '24px','font-size':'14px'}, 300);
			}
		});

		$('textarea#mensagem').focusin(function(){
			$('lable[for="mensagem"]').animate({'bottom': '132px','font-size':'11px'}, 300);

		}).focusout(function(){
			if($(this).val() == ''){
				$('lable[for="mensagem"]').animate({'bottom': '100px','font-size':'14px'}, 300);
			}
		});

		$('.link-menu').click(function(){
			
			var _id = $(this).find('a').attr('link');
			
			//alert(_id);

			$("html, body").animate({ scrollTop: $('#'+_id).offset().top }, 1000);
			
			return false;
		})	
			
		$('#homeForm').submit(function(){

			$.ajax({
				url: '{{ url("contato") }}',
				method: 'POST',
				data: $(this).serialize(),
				error: function (request, error) {
					swal({
						title: "Desculpe, houve um erro!",
						text: "Não foi possível enviar seu contato, certifique-se que todos os campos foram preenchidos e tente novamente.",
						type: 'error'
					});
					return true;
				},
				success: function(data){

					swal({
						title: "Seu contato foi enviado",
						text: "Nossa equipe já recebeu o seu contato e em breve o retornaremos. Obrigado.",
						type: 'success'
					});

					$('#homeForm input[name="nome"]').val('');
					$('#homeForm input[name="email"]').val('');
					$('#homeForm textarea').val('') = '';

					return true;
					
				}
			})

			return false;

		})

		$('input[name="cep"]').stop().on('focusout', function(){
				
			var cep = $(this).val().replace(/ /g,'').replace('-','')

			if(cep.length == 8){
				$.ajax({
					dataType: 'json',
					url: 'https://viacep.com.br/ws/'+ cep +'/json/',
					method: 'GET',
					success: function(response){
						if(response.erro){
							alert("O CEP digitado está incorreto.")
							$('input[name="logradouro"]').val('');
							$('input[name="bairro"]').val('');
							$('input[name="cidade"]').val('');
							$('input[name="estado"]').val('');
						}else{
							console.log(response);
							$('input[name="logradouro"]').val(response.logradouro);
							$('input[name="bairro"]').val(response.bairro);
							$('input[name="cidade"]').val(response.localidade);
							$('input[name="estado"]').val(response.uf);
						}						
					}
				});
				
			}else{
				alert("O CEP digitado está errado.")
			}

			return false
			
		});	

	})
	</script>

	{{-- Modals --}}
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="#loginModal">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Modal title</h4>
		</div>
		<div class="modal-body">

		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save changes</button>
		</div>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
