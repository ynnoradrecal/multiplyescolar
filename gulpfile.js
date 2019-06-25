var elixir = require('laravel-elixir');
			 require('laravel-elixir-vueify');

var _switch;

_switch = Object.assign({}, _switch, {
	"loja":true,
	"admin":false
})

elixir(function(mix) {

	if(_switch.loja) {
		ManagerLoja( mix )
	}

	if(_switch.admin) {
		ManagerAdmin( mix )
	}

});

// MANAGER LOJA
function ManagerLoja( mix ) 
{
    // sass
    mix.sass("../store/sass/store.scss");

    // scripts
    mix.scripts([
      "../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js",
      "../store/js/lightbox.min.js",
      "../store/js/isotope.pkgd.min.js",
      "../store/js/masonry.pkgd.min.js",
	  "../../../node_modules/icheck/icheck.js",
	  "../store/js/src/**/*.js",
      "../store/js/custom.js",
    ], "public/js/store.js");

    mix.browserify("../store/js/custom.js");
}


// MANAGER ADMIN
function ManagerAdmin( mix ) 
{
	// #sass
    mix.sass("../admin/sass/componentes.scss");
    mix.sass("../admin/sass/main.scss");

	// #scripts
    mix.scripts([

		"../../../node_modules/gentelella/vendors/moment/moment.js",

		"../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js",

		"../../../node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.js",
		"../../../node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.js",
		"../../../node_modules/gentelella/vendors/iCheck/icheck.js",
		"../../../node_modules/gentelella/vendors/dropzone/dist/dropzone.js",
		"../../../node_modules/gentelella/vendors/pnotify/dist/pnotify.js",
		"../../../node_modules/gentelella/vendors/bootstrap-wysiwyg/src/bootstrap-wysiwyg.js",
		"../../../node_modules/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js",


		// bootstrap-daterangepicker
		"../../../node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js",

		"../../../node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js",
		"../../../node_modules/blueimp-file-upload/js/jquery.iframe-transport.js",
		"../../../node_modules/blueimp-file-upload/js/jquery.fileupload.js",

		"../../../node_modules/waterfall/new-waterfall.js",

		"../../../node_modules/gentelella/src/js/custom.js",

    ], "public/js/componentes.js");

    mix.browserify("../admin/js/admin.js");

}
