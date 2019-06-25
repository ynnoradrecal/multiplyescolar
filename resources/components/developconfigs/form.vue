<template lang="html" src="../../views/developer/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/developer.scss"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue"
import Facebook from "./forms/facebook.vue"
import Google from "./forms/google.vue"

export default {

	components: { PulseLoader, Facebook, Google },

	props: ['host'],

	data() {
		return {
			bool: {
				load: false
			},
			type: '',

			form: '',

		}
	},

	mounted() {

		this.form = this.$root.$refs.developer.$refs.form;

	},

	methods: {

		update( arg ) {

			var src = this.$resource( arg.host +"/put" ),
				store = this.form.$refs[this.type].store;

			this.bool.load = true;

			src.save( store ).then(function( response ) {

				var data = response.data;

				this.bool.load = false;
				this.$swal(data.title, data.text, data.type);


			}, function( response ) {

				this.error = [];
				this.error = response.data;

				this.bool.load = false;

			});

		},

		ICheck() {

			var self = this

			$("input[type='checkbox']").iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});

			$("input[type='checkbox']").off("click").on('ifClicked', function(event){

				var store = self.form.$refs[self.type].store

				if( store.status == 1 ) {
					store.status = 0
					return false
				}

				store.status = 1

			});

		},

		CheckedICheck() {

			var self = this

			$("input[type='checkbox']").iCheck("uncheck")

			// status
			if( self.form.$refs[self.type].store.status == 1 ) {		
				$("input[type='checkbox']").iCheck("check")
			}

		}

	}

}
</script>  