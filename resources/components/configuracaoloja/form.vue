<template lang="html" src="../../views/loja/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue"
{/*import Contato from "./forms/contato.vue"*/}

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

			loja: {},
			contato: {},

		}
	},

	mounted() {

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

			var self = this

			$("input[type='checkbox']").iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});

			$("input[type='checkbox']").off("click").on('ifClicked', function(event){

				if( self[self.type].status == 1 ) {
					self[self.type].status = 0
					return false
				}

				self[self.type].status = 1

			});

		},

		CheckedICheck() {

			var self = this

			$("input[type='checkbox']").iCheck("uncheck")

			// status
			if( self[self.type].status == 1 ) {		
				$("input[type='checkbox']").iCheck("check")
			}

		}

	}

}
</script>  