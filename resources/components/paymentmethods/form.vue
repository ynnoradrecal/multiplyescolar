<template lang="html" src="../../views/pagamento/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue";

export default {

	components: { PulseLoader },

	data() {
		return {
			loader: 'off',
			form: '',
			error: [],
			store: {
				id: "",
				slug: "",
				nome: "",
				email: "",
				token: "",
				url_redirect: "",
				status: ""
			}
		}
	},

	mounted() {
	},

	methods: {
		
		create( arg ) {
			
			var _resource, _list

			_resource = this.$resource( arg.host +"/create" )
			_list = this.$root.$refs.payment.$refs.list // component
			
			_resource.save( this.store ).then(function( response ) {
				
				_list.data.push({
					id: response.data.id, // id do back
					titulo: this.store.titulo // titulo do front
				})

				_list.refresh_rows()

			}, function( response ) {
				this.error = [] 
				this.error = response.data
			})

		},

		update( arg ) {

			this.loader = 'on'

			var _resource, _list

			_resource = this.$resource( arg.host +"/update" )
			_list = this.$root.$refs.payment.$refs.list		//	component payment

			_resource.update( this.store ).then(function( response ) {

				this.$swal('Sucesso!', this.store.titulo +' atualizado.', 'success')
				this.loader = 'off'

				/*for( var i = 0; i < _list.data.length; i++ ){
					if(this.store.id == _list.data[i].id ){
						_list.data[i].nome = this.store.nome
					}
				}*/

				for( var i = 0; i < _list.data.length; i++ ){
					if(this.store.modulo_id == _list.data[i].id ){
						_list.data[i].nome = this.store.nome
					}
				}

				_list.refresh_rows()

			}, function( response ) {
				this.error = [] 
				this.error = response.data
			})

		},

		newMethod( arg ) { // se extiver preenchido com algum dado de edição limpa os campos
			
			if( this.store.id != '')
			{
				this.store.id = ''
				this.store.titulo = ''
				this.store.email = ''
				this.store.token = ''
				this.store.url_redirect = ''
				this.store.status = 0
			}

		},

		deleteMethod( arg ) {
			
			if( this.store.id == ''){
				
				alert('Por favor escolha um dos métodos de pagamento para deleta-lo')
				
			}else{
				
				var _resource, _list

				_resource = this.$resource( arg.host +"/delete" )
				_list = this.$root.$refs.payment.$refs.list // component

				_resource.update( this.store ).then(function( response ) {

					_list.data = JSON.parse(response.data)
					_list.refresh_rows()

				}, function( response ) {
					this.error = [] 
					this.error = response.data
				})
			}
		},
		show( arg ) {

			var _resource, _list

			_resource = this.$resource( arg.host +"/init" )
			_list = this.$root.$refs.payment.$refs.list // component

			_resource.show().then(function( response ) {

				_list.data = JSON.parse(response.data)
				_list.refresh_rows()

			}, function( response ) {
				this.error = [] 
				this.error = response.data
			})
		}
	}

}
</script>  