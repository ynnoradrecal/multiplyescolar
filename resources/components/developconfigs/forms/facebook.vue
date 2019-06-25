<template lang="html" src="../../../views/developer/forms/facebook.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../../plugins/vue-spinner.vue";
import Upload from './upload.vue';

export default {

	components: { 
		PulseLoader,
		Upload
	},

	props: ["type", 'host'],

	data() {
		return {
			
			url: '',

			loader: 'off',

			bool: {
				load: false,
			},
			
			error: [],
			store: {
				status: 0,
				nome: 'Facebook',
			},

			image: {
				save: true,
				delete: false
			},

			// components
			root: '',
			form: '',


		}
	},

	mounted() {

		this.root = this.$root.$refs.developer;
		// url
		this.url = this.root.url;

	},

	methods: {

		excluir_images() {

			this.store.file = [];
			this.button_image('save');

			// var src = this.$resource( this.host +'/init' );

			// this.bool.form = true;
			// src.save({'methods':'excluir_image', 'image':this.model.capa}).then(function() {

			// 	this.model.capa = [];
			// 	this.bool.form = false;
			// 	this.button_image('save');

			// });

		},

		button_image( button ) {

			for( var item in this.image ) {
				this.image[item] = false;
			}

			this.image[button] = true;

		}

	}


}
</script>

<style>
	#files{
		display: block !important;
	}
</style>