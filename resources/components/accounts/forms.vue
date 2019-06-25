<template lang="html" src="../../views/contas/forms.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import Instituicao from "./forms/instituicao.vue";
import Alunos from "./forms/alunos.vue";
import Outros from "./forms/outros.vue";

//import PulseLoader from "../plugins/vue-spinner.vue"

var PulseLoader = require('vue-spinner/dist/vue-spinner.min').PulseLoader;

export default {

	components: { 
		Instituicao, 
		Alunos, 
		Outros, 
		PulseLoader 
	},

	props: ['host'],

	data() {
		return {

			color: "#3498DB",

			error: {},

			loader: false,
			title: {text:"Instituiçao", class:"fa fa-bank"},

			bool: {
				load: false
			},

			root: "",
			form: "",
			list: "",

			swal: {
				alert: {
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#169F85',
					cancelButtonColor: '#d9534f',
					confirmButtonText: 'Sim, Deletar!'
				}
			}

		}
	},

	mounted() {

		this.root = this.$root.$refs.accounts
		this.form = this.root.$refs.forms.$refs[this.root.type]
		this.list = this.root.$refs.list

	},

	methods: {

		Store() {

			this.bool.load = true
			this.QueryResource( this.$resource( this.root.host +"/init" ), "save", this.form.model )

		},

		Put() {
			
			this.bool.load = true

			var model = this.Proofing()
			
			// verificando se foi modificado algum dado, para enviar a requisição de alteração
			if( Object.keys( model ).length == 0 ) {
				this.bool.load = false
				return false
			}

			this.QueryResource( this.$resource( this.root.host +"/init" ), "put", model )

		},

		Destroy() {
			
			var self = this,
				title = '',
				swal = this.swal.alert;

			title = this.form.title == 'Alunos' ? 'Aluno' : 'Instituicão' ;

			swal.title = 'Deseja excluir '+ title.toLowerCase() +' "'+ self.form.model.nome +'"';
			swal.text  = title +' "'+ self.form.model.nome +'" sera permanentemente apagada.';

			this.$swal( this.swal.alert ).then(function() {

				self.bool.load = true					
				self.QueryResource( self.$resource( self.root.host +"/init" ), "delete", self.form.model )

			})

		},

		QueryResource( src, methods, model ) {

			src.save( {
				"methods":methods, 
				"post":model, 
				"form":this.root.type 
			} ).then(function( res ) {


				this.Alert( res.data.alert )
				this.Error([])
				this.bool.load = false

				if( methods == 'save' || 'delete' ) {
					this.form.model = {'cep':''};
				}

				this.list.RefreshDataTable()
				
			}, function( res ) {

				this.Error( res.data )

				this.bool.load = false

			})

		},

		Alert( data ) {

			if( typeof data != 'undefined' ) {
				this.$swal(data.title, data.text, data.type)
			}

		},

		Error( data ) {

			var item

			this.error = {}

			for( var obj in data ) {
				
				item = obj.replace("post.", "")
				this.error[ item ] = [ data[obj][0].replace("post.", "") ]

			}

		},

		Proofing() {

			var id     = this.form.model.id,
				index,
				data   = this.list.data,
				list   = {};

			data.forEach(function(item, i, list) {
				if( item.id == id ) {
					index = i
				}
			})

			for( var i in data[index] ) {

				if( data[index][i] != this.form.model[i] ) {
					list = Object.assign({}, list, {[i]:this.form.model[i]})
				}

			}

			list = Object.assign({}, list, {'id':data[index].id});

			return list

		}

	}

}
</script>
<style>
	.loader_forms{ position: relative; top:8px; }
</style>
