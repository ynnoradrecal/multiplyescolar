<template lang="html">
	<div class="col-md-12 col-dm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_title">
				<h2><i class="fa fa-pencil-square-o"></i> Configuração</h2>
				<!--pulse-loader v-show="loader" class="loader_forms pull-right"></pulse-loader-->
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<form class="form-horizontal form-label-left" method="post">
					<fieldset>
						<input class="form-control" placeholder="..." type="hidden" v-model="store.id">
						<div class="form-group" v-bind:class="{'has-error':error.nome}">
							<div class="col-xs-12">
								<label for="">Nomde do Módulo</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.nome">
								<span class="help-block" v-for="error in error.nome">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.email}">
							<div class="col-xs-12">
								<label for="">E-mail</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.email">
								<span class="help-block" v-for="error in error.email">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.token}">
							<div class="col-xs-12">
								<label for="">Token</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.token">
								<span class="help-block" v-for="error in error.token">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.url_redirect}">
							<div class="col-xs-12">
								<label for="">URL de Redirecionamento</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.url_redirect">
								<span class="help-block" v-for="error in error.url_redirect">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.status}">
							<div class="col-xs-12">
								<label for="">Status</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.status">
								<span class="help-block" v-for="error in error.status">{{ error }}</span>
							</div>
						</div>

					</fieldset>
				</form>
			</div>

		</div>
	</div>
</template>

<script>

import PulseLoader from "../plugins/vue-spinner.vue"

export default {

	components: { PulseLoader },

	data() {
		return {
			loader: true,
			error: [],
			store: {
				id: "",
				titulo: "",
				email: "",
				token: "",
				url_redirect: "",
				status: ""
			}
		}
	},

	mounted() {
		this.show()
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

			var _resource, _list

			_resource = this.$resource( arg.host +"/update" )
			_list = this.$root.$refs.payment.$refs.list // component			

			_resource.update( this.store ).then(function( response ) {

				this.$swal('Sucesso!', this.store.titulo +' atualizado.', 'success')

				for( var i = 0; i < _list.data.length; i++ ){
					if(this.store.id == _list.data[i].id ){
						_list.data[i].titulo = this.store.titulo
						_list.data[i].email = this.store.email
						_list.data[i].token = this.store.token
						_list.data[i].url_redirect = this.store.url_redirect
						_list.data[i].status = this.store.status
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