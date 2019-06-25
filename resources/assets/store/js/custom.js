$(document).ready(function(){

	$('input[name="cep"]').mask('99999-999');
	$('input[name="telefone"]').mask('(99) 9999-9999');
	$('input[name="celular"]').mask('(99) 9 9999-9999');
	$('input[name="data_nascimento"]').mask('99/99/9999');
	$('input[name="cpf"]').mask('999.999.999-99');
	$('#clienteCPF').mask('99999999999');
	$('#card_number').mask('9999 9999 9999 9999');

	$('homeForm').

	$('.checkCart').on('click', function(e){
		
		var link = $(this).attr('href');

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			method: 'POST',
			dataType: 'json',
			url: "http://multiply.art.br/escolar/checa-carrinho",
			success: function(data) {
				
				if(data.cart){
					
					$.confirm({
						title: 'Atenção!',
						content: 'Se você sair do processo de compra, seu carrinho será perdido!',
						theme: 'supervan',
						buttons: {
							Sair: {
								btnClass: 'btn-red',
								action: function () {								
									
									$.ajax({
										method: 'get',
										dataType: 'json',
										url: "http://multiply.art.br/escolar/kill-cart",
										success: function(data) {
											if(data.success){
												window.location.href = link;
											}
										}
									});						
									
								}
							},
							Fechar: function () {
							}
						}
					});

				} else {
					window.location.href = link;
				}
				
				console.log(data.cart);				
			},
			error: function(){
				window.location.href = link;
			}
		});

		// alert(link);
		e.preventDefault();
	})
	

	$('#login-tab').click(function(){
		$(".title-login-cadastro").empty();
		$(".title-login-cadastro").append("Login");
	});


	$('#cadastro-tab').click(function(){
		$(".title-login-cadastro").empty();
		$(".title-login-cadastro").append("Cadastro");
	});


	$('input#nome').focusin(function(){
		$('lable[for="nome"]').animate({'bottom': '53px'}, 100);
	});


	$("#searchNav a.search").click(function(){
		$("#searchNav").submit();
		return false;
	});


	$('#eventos .grid').mouseenter(function(){

		$(this).find('.mask').stop().animate({
			'left': '0px',
		}, 300)

	}).mouseleave(function(){

		$(this).find('.mask').stop().animate({
			'left': '-368px',
		}, 300)

	});


	// ativa efeito no click quando for mobile
	$('#eventos .grid').click(function(){		
		$(this).find('.mask').stop().animate({
			'left': '0px',
		}, 300)
	})

	
	$('#galeria .grid-item .single-image').mouseenter(function(){
		
		$(this).find('.buttons').toggle().addClass('animated slideInUp');
		$(this).find('img').stop().animate({'margin-top':'-15px'}, 500);

	}).mouseleave(function(){

		$(this).find('img').stop().animate({'margin-top':'0px'}, 500);

		$(this).find('.buttons').fadeOut(200, function() {
			$(this).css("display","none").removeClass('animated slideInUp');
		});

	});


	$('#galeria .grid-item .single-image').click(function(){		
		$(this).find('.buttons').slideToggle('fast').addClass('animated slideInUp');
	});


	$('.grid').masonry({
		itemSelector: '.grid-item'
	});


	lightbox.option({
		'resizeDuration': 100,
		'wrapAround': true,
		'alwaysShowNavOnTouchDevices': 	false
	});


	$('#top-user, #top-cart').hover(function(){
		$(this).find('.sub-menu').stop().slideToggle('fast');
	})

	var trigger = $('.hamburger'), overlay = $('.overlay'), isClosed = false;


	trigger.click(function () {
	  hamburger_cross();
	});


	function hamburger_cross() {

		if (isClosed == true) {
			overlay.hide();
			trigger.removeClass('is-open');
			trigger.addClass('is-closed');
			isClosed = false;
		} else {
			overlay.show();
			trigger.removeClass('is-closed');
			trigger.addClass('is-open');
			isClosed = true;
		}
	}


  	$('[data-toggle="offcanvas"]').click(function () {
		$('#wrapper').toggleClass('toggled');
  	});


	$("#resetPassForm").submit(function(e) {

  		var action = $(this).attr('action');
		$.ajax({
			   type: "POST",
			   url: action,
			   data: $(this).serialize(), // serializes the form's elements.
			   success: function(data){
				   alert(data); // show response from the php script.
			   },
			   error: function(data){
			   	 alert(email[1][0]);
			   }
		});

		 e.preventDefault(); // avoid to execute the actual submit of the form.
	});


	$("#cadastroForm").submit(function(e) {
  		var action = $(this).attr('action');

		$.ajax({
			   type: "POST",
			   url: action,
			   data: $(this).serialize(), // serializes the form's elements.
			   success: function(data)
			   {
				   alert(data); // show response from the php script.
			   },
			   error: function(data){
			   	 alert(email[1][0]);
			   }
		});

		 e.preventDefault(); // avoid to execute the actual submit of the form.
	});


	$('#btnAdicionar').click(function(){
		
		var val = $('#addComent textarea').val();

		if(val != ''){			
			$('.setCommentHere').val(val);
		}

		$('#addComent textarea').val('');

		$('.setCommentHere').removeClass("setCommentHere");
		$('#modalAddComent').modal('hide');

		return false;
	});


	$('#modalAddComent').on('hidden.bs.modal', function (e) {
		$('.setCommentHere').removeClass("setCommentHere");
	});


	$('.modal-reset-pass').click(function(){
		$('#modalLogin').modal('hide');
		$('#modalLogin').on('hidden.bs.modal', function (e){
			$('#modalResetPass').modal('show');
		});

	});


	$('.voltar-login').click(function(){
		$('#modalResetPass').modal('hide');
		$('#modalResetPass').on('hidden.bs.modal', function (e){
			$('#modalLogin').modal('show');
		});
	});


	$('.modal-cadastro').click(function(){
		$('#modalLogin').modal('hide');
		$('#modalLogin').on('hidden.bs.modal', function (e){
			$('#modalCadastro').modal('show');
		});
	});


	$('.ja-sou-cadastrado').click(function(){
		$('#modalCadastro').modal('hide');
		$('#modalCadastro').on('hidden.bs.modal', function (e){
			$('#modalLogin').modal('show');
		});
	});

});

function openCommentModal( id )
{
	$(id).addClass("this");
	$('#modalAddComent').modal('show');
	$('#'+id).addClass("setCommentHere");
	return false;
}


	