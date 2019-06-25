<template lang="html" src="../../views/eventos/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

	import PulseLoader from "../plugins/vue-spinner.vue";
	import Upload from "./upload.vue";

	export default {

		components: { 
			PulseLoader,
			Upload
		},

		props: ['host', 'url'],

		data() {
			return {

				swal: {
					alert:{
						title: 'Deseja excluir esse evento?',
						text: 'Evento sera permanentemente apagada.',
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#169F85',
						cancelButtonColor: '#d9534f',
						confirmButtonText: 'Sim, Deletar!'
					}
				},

				// button images
				image: {
					save: true,
					delete: false
				},

				error: [],

				model: {},

				bool: {
					load: false,
					form: false
				},

				//compoents
				root: '',
				list: '',

			}
		},

		mounted() {
			this.root = this.$root.$refs.events;
			this.list = this.root.$refs.list
		},

		methods: {
			
			save() {

				var src = this.$resource( this.host +'/init' ),
					field = '';


				this.bool.form = true;

				src.save({'methods':'save', 'data':this.model}).then(function( res ) {

					var alert = res.data.alert;

					this.bool.form = false;
					this.button_image('save');

					this.model = [];
					this.error = [];

					this.$swal(alert.title, alert.text, alert.type);

					this.list.dataTable.clear().draw();
					this.list.GetRowsDataTable();

				}, function( res ) {

					this.throw_error(res.data);
					this.bool.form = false;

				})

			},

			put() {

				this.bool.form = true;

				var src = this.$resource( this.host +'/init' );

				src.save({'methods':'put', 'data':this.model}).then(function(res) {

					var alert = res.data.alert;

					this.error = [];
					this.bool.form = false;

					this.$swal(alert.title, alert.text, alert.type);

					this.list.dataTable.clear().draw();
					this.list.GetRowsDataTable();

				}, function(res) {

					this.throw_error(res.data);
					this.bool.form = false;
				})

			},

			destroy() {

				var src = this.$resource( this.host +'/init' ), 
					self = this;

				this.$swal( this.swal.alert ).then(function() {

					self.bool.form = true;

					src.save({
						'methods':'destroy', 
						'data':self.model
					}).then(function(res) {

						var alert = res.data.alert;

						self.error = [];
						self.bool.form = false;
						self.model = [];

						self.$swal(alert.title, alert.text, alert.type);

						self.list.dataTable.clear().draw();
						self.list.GetRowsDataTable();

					});
				});

					

			},

			excluir_images() {

				var src = this.$resource( this.host +'/init' );

				this.bool.form = true;
				src.save({'methods':'excluir_image', 'image':this.model.capa}).then(function() {

					this.model.capa = [];
					this.bool.form = false;
					this.button_image('save');

				});

			},

			throw_error( data ) 
			{
				var field = '', 
					error = [];

				if( Object.keys(data).length == 0 ) {
					this.error = {};
				}else{

					Object.keys(data).forEach(function(item, i, list) {

						field = item.replace('data.', '');
						
						error[field] = [data[item][0].replace('data.', '')];

					})

					this.error = error;

				}

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