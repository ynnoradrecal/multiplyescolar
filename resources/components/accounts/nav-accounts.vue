<template lang="html" >
	<div class="x_panel">
		<div class="x_title">
			<h2><i class="fa fa-gear"></i> Categorias</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="col-md-10 col-md-offset-1">
				<a class="btn btn-app" v-on:click="set_link(0)">
					<i class="fa fa-bank"></i> Instituição
				</a>
				<a class="btn btn-app" v-on:click="set_link(1)">
					<i class="fa fa-graduation-cap"></i> Alunos
				</a>
				<a class="btn btn-app" v-on:click="set_link(2)">
					<span class="badge bg-red">0</span>
					<i class="fa fa-group"></i> Clientes
				</a>
			</div>
		</div>
	</div>
</template>
<script>

	export default {

		data() {
			return {

				title: [
					{text:"Instituiçao", class:"fa fa-bank", slug:"instituicao"},
					{text:"Alunos", class:"fa fa-graduation-cap", slug:"alunos"},
					{text:"Clientes", class:"fa fa-group", slug:"outros"}
				], 

				root: "",

			}
		},

		mounted() {

			this.root = this.$root.$refs.accounts

		},

		methods:{

			set_link( index ) {

				var accounts = this.$root.$refs.accounts;
				var forms    = accounts.$refs.forms;

				var types    = ["instituicao", "alunos", "outros"]	

				if( accounts.form == types[ index ] )
					return false

				// closed forms
				types.forEach(function( item, i ) {
					forms.$refs[ item ].status = false
				})

				forms.$refs[ types[ index ] ].status = true // open form 
				forms.form = forms.$refs[types[ index ]];

				this.root.type = this.title[ index ].slug
				this.root.$refs.list.RefreshDataTable()
				this.root.CleanModel()

				accounts.form  = this.title[ index ].slug
				accounts.title = this.title[ index ].text

				accounts.$refs.list.loader = true

				if( types[ index ] == "alunos" ) {
					forms.$refs[ types[ index ] ].get_instituicao();
				}

				if( types[ index ] == "outros" ) {
					accounts.EnableButton([]);
				}else{
					accounts.EnableButton([0]);
				}

				for( var i in {"forms":null, "list":null} ) {
					accounts.$refs[ i ].title.text  = this.title[ index ].text
					accounts.$refs[ i ].title.class = this.title[ index ].class
				}

			},


		},

	}
</script>

