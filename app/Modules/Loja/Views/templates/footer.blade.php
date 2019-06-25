	<footer>
		<div class="container">

			<section class="col-md-5 col-sm-5 col-xs-12 atendimento grid-one">
				<article>
					<header class="col-xs-12">
						<h3>ATENDIMENTO</h3>
					</header>
					
					<br>
					<div class="mapa col-md-4 col-sm-4 col-xs-12 thumbnail">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3655.377687280126!2d-46.56162198547968!3d-23.626641469890284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5cd9fecd8343%3A0x5de40de4cc111f0c!2sR.+Ribeir%C3%A3o+Preto%2C+147+-+Ol%C3%ADmpico%2C+S%C3%A3o+Caetano+do+Sul+-+SP%2C+09570-140!5e0!3m2!1spt-BR!2sbr!4v1528144875431" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
					<ul class="col-md-8 col-sm-8 col-xs-12">
						<li>
							<address>
								<i class="fa fa-map-marker"></i> Rua Ribeirão Preto, 147 <br> B. Olímpico - São Caetano do Sul / SP
							</address>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-envelope-square"></i> Email: atendimento@multiply.art.br
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-phone-square"></i> <span>11</span> 2564-6025 / <span>11</span> 2376-2905
							</a>
						</li>
						<!-- <li>
							<i class="fa fa-clock-o"></i> Segunda a Sexta das 9h às 18h
						</li> -->
					</ul>
				</article>
			</section>

			<section class="col-md-3 col-sm-3 col-xs-12 text-center grid-two">
				<article class="redes-sociais">
					<header class="col-xs-12">
						<h3>REDES SOCIAIS</h3>
					</header>
					<ul class="list-inline">
						<li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-youtube-square"></i></a></li>
					</ul>
				</article>
				<article class="politica">
					<header class="col-xs-12">
						<h3>POLÍTICAS</h3>
					</header>
					<ul>
						<li><a href="">Política de Compra</a></li>
						<li><a href="">Política de Entrega</a></li>
					</ul>
				</article>
			</section>

			<section class="col-md-4 col-sm-4 col-xs-12 grid-three text-center">
				<article class="pagamento">
					<header class="col-xs-12">
						<h3>FORMAS DE PAGAMENTOS</h3>
					</header>
					<figure>
						<img src="{{ asset('images/logo-pagseguro.png') }}" alt="Formas de Pagamentos | PagSeguro" width="50%">
					</figure>
				</article>
				<article>
					<header class="col-xs-12">
						<h3>SELOS</h3>
					</header>
					<figure>
						<a style="display:block;margin-top:18px;" href="https://transparencyreport.google.com/safe-browsing/search?url=https:%2F%2Fwww.multiply.art.br%2Fescolar" target="_blank">
						<img width="40%" src="{{ asset('images/selo_site_seguro_google.jpg') }}" alt="">
						</a>
					</figure>
				</article>
				<br>
				
			</section>

		</div>

		<div class="down-footer">
			<div class="container text-center">
			Todos os direitos reservados {{ date('Y') }} - Multiply Escolar
			</div>
			<div class="text-center agencia">
				<a href="http://www.wa5.com.br" target="_blank">&nbsp;www.wa<i class="fa fa-html5"></i>.com.br</a>
			</div>
		</div>
	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
	<script src="{{ asset('js/slick.min.js') }}"></script>
	<script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
	<!-- <script src="{{ asset('js/cart.js') }}"></script> -->
	<!-- <script src="{{ asset('js/store.js') }}"></script> -->
	<script src="{{ asset('js/beta.js') }}"></script>
	<script src="{{ asset('js/router.js') }}"></script>

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

			$('#buttonFake').css('display', 'block');
			$('#senderButton').css('display', 'none');

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
					$('#buttonFake').css('display', 'none');
					$('#senderButton').css('display', 'block');
					return true;
				},
				success: function(data){

					swal({
						title: "Seu contato foi enviado",
						text: "Nossa equipe já recebeu o seu contato e em breve o retornaremos. Obrigado.",
						type: 'success'
					}, function(){
						$('#buttonFake').css('display', 'none');
						$('#senderButton').css('display', 'block');	
					});

					$('#homeForm input[name="nome"]').val('');
					$('#homeForm input[name="email"]').val('');
					$('#homeForm textarea').val('') = '';
					
					return true;
					
				}
			})

			return false;

		})

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
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.modal -->
