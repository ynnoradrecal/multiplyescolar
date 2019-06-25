(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

$(document).ready(function () {

	$('.single-item').slick();

	$('input[name="cep"]').mask('99999-999');
	$('input[name="telefone"]').mask('(99) 9999-9999');
	$('input[name="celular"]').mask('(99) 9 9999-9999');
	$('input[name="data_nascimento"]').mask('99/99/9999');
	$('input[name="cpf"]').mask('999.999.999-99');

	$('#login-tab').click(function () {
		$(".title-login-cadastro").empty();
		$(".title-login-cadastro").append("Login");
	});

	$('#cadastro-tab').click(function () {
		$(".title-login-cadastro").empty();
		$(".title-login-cadastro").append("Cadastro");
	});

	$("#searchNav a.search").click(function () {
		$("#searchNav").submit();
		return false;
	});

	// $('#eventos .grid').on('mousenter', function(e){
	// 	$(this).find('.mask').animate({
	// 		'left': '0px',
	// 	}, 1000)
	// }, function(){
	// 	$(this).find('.mask').fadeOut(300, function() {
	// 		$(this).css("display","none").removeClass('animated bounceInLeft');
	// 	});
	// })

	$('#eventos .grid').mouseenter(function () {

		$(this).find('.mask').stop().animate({
			'left': '0px'
		}, 300);
	}).mouseleave(function () {

		$(this).find('.mask').stop().animate({
			'left': '-368px'
		}, 300);
	});

	// ativa efeito no click quando for mobile
	$('#eventos .grid').click(function () {
		$(this).find('.mask').stop().animate({
			'left': '0px'
		}, 300);
	});

	$('#galeria .grid-item .single-image').mouseenter(function () {

		$(this).find('.buttons').toggle().addClass('animated slideInUp');
		$(this).find('img').stop().animate({ 'margin-top': '-15px' }, 500);
	}).mouseleave(function () {

		$(this).find('img').stop().animate({ 'margin-top': '0px' }, 500);

		$(this).find('.buttons').fadeOut(200, function () {
			$(this).css("display", "none").removeClass('animated slideInUp');
		});
	});

	$('#galeria .grid-item .single-image').click(function () {
		$(this).find('.buttons').slideToggle('fast').addClass('animated slideInUp');
	});

	$('.grid').masonry({
		itemSelector: '.grid-item'
	});

	lightbox.option({
		'resizeDuration': 100,
		'wrapAround': true,
		'alwaysShowNavOnTouchDevices': false
	});

	$('#top-user, #top-cart').hover(function () {
		$(this).find('.sub-menu').stop().slideToggle('fast');
	});

	var trigger = $('.hamburger'),
	    overlay = $('.overlay'),
	    isClosed = false;

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

	$("#resetPassForm").submit(function (e) {

		var action = $(this).attr('action');
		$.ajax({
			type: "POST",
			url: action,
			data: $(this).serialize(), // serializes the form's elements.
			success: function success(data) {
				alert(data); // show response from the php script.
			},
			error: function error(data) {
				alert(email[1][0]);
			}
		});

		e.preventDefault(); // avoid to execute the actual submit of the form.
	});

	$("#cadastroForm").submit(function (e) {

		var action = $(this).attr('action');

		$.ajax({
			type: "POST",
			url: action,
			data: $(this).serialize(), // serializes the form's elements.
			success: function success(data) {
				alert(data); // show response from the php script.
			},
			error: function error(data) {
				alert(email[1][0]);
			}
		});

		e.preventDefault(); // avoid to execute the actual submit of the form.
	});

	$('#btnAdicionar').click(function () {

		var val = $('#addComent textarea').val();

		if (val != '') {
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

	$('.modal-reset-pass').click(function () {
		$('#modalLogin').modal('hide');
		$('#modalLogin').on('hidden.bs.modal', function (e) {
			$('#modalResetPass').modal('show');
		});
	});

	$('.voltar-login').click(function () {
		$('#modalResetPass').modal('hide');
		$('#modalResetPass').on('hidden.bs.modal', function (e) {
			$('#modalLogin').modal('show');
		});
	});

	$('.modal-cadastro').click(function () {
		$('#modalLogin').modal('hide');
		$('#modalLogin').on('hidden.bs.modal', function (e) {
			$('#modalCadastro').modal('show');
		});
	});

	$('.ja-sou-cadastrado').click(function () {
		$('#modalCadastro').modal('hide');
		$('#modalCadastro').on('hidden.bs.modal', function (e) {
			$('#modalLogin').modal('show');
		});
	});
});

function openCommentModal(id) {
	$(id).addClass("this");
	$('#modalAddComent').modal('show');
	$('#' + id).addClass("setCommentHere");
	return false;
}

},{}]},{},[1]);

//# sourceMappingURL=custom.js.map
