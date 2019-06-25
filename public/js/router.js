app.router = (function(parent, $) {
	
	'use strict';

	var pub = {

		host: 'https://multiply.art.br/escolar/beta',

		group: [

			{url:'login-cadastro', controll:'increate'},
			{url:'minha-conta', controll:'account'},
			{url:'eventos', controll:'events'},
			{url:'galerias', controll:'gallery'},
			{url:'confirmar', controll:'gallery'},
			{url:'adicionais', controll:'adis'},
			{url:'frete', controll:'delivery'},
			{url:'checkout', controll:'checkout'}

		],

	};

	pub.init = function() {

		var self = this, geturl, index;

		geturl = location.href.replace(self.host, '');
		
		self.group.forEach(function(item, i) {

			index = geturl.split('/').indexOf(item.url);
			
			if( item.url == geturl.split('/').splice(index, 1).join('') ) {
				app[item.controll].init();
			}

		});

	}

	return pub;

}(app || {}, jQuery));

app.router.init();