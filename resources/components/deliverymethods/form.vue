<template lang="html" src="../../views/entrega/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue"

export default {

	components: { PulseLoader },

	data() {
		return {

			loader: 'off',
			error: [],
			type: '',
			store: {
				id: "",
				nome: "",
				slug: "",
				status: 0
			},

			correios: {},
			frete_gratis: {},
			retirar_no_local: {},
			transportadora: {},

		}
	},

	mounted() {

		this.ICheck();

	},

	methods: {
		
		
		update( arg ) {


			this.loader = 'on'

			var src = this.$resource( arg.host +"/put" );

			src.save( this[this.type] ).then(function( response ) {

				var data = response.data;

				this.$swal(data.title, data.text, data.type);

				this.loader = 'off';


			}, function( response ) {
				this.error = [];
				this.error = response.data;
			})

		},

		ICheck() {

			var self = this;

			$("input[type='checkbox']").iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});

			$("input[type='checkbox']").on('ifClicked', function(event){

				var attr = $(this).attr('id'),
					status = 1;

				console.log(attr +': '+ self[self.type][attr]);

				if( self[self.type][attr] == 1 ) {
					status = 0;
				}

				self[self.type][attr] = status;
		

			});

		},

		CheckedICheck() {

			var self = this,
				attrs = ['status', 'pac', 'sedex', 'sedex_10'];

			$("input[type='checkbox']").iCheck("uncheck")

			attrs.forEach(function(attr, i, list) {
				if( self[self.type][attr] == 1 ) {		
					$('#'+ attr).iCheck("check")
				}
			})

		}

		
	}

}
</script>  