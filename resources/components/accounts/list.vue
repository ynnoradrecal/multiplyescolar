<template lang="html" src="../../views/contas/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

	import Dtable from "../datatable.vue"
	import PulseLoader from "../plugins/vue-spinner.vue"

	export default {

		components: { Dtable, PulseLoader },

		data() {
			return {
				clear_json: ["HTTP/1.0 200 OK", "Cache-Control: no-cache", "Content-Type:  application/json"],
				loader: true,
				title: {text:"Instituiçao", class:"fa fa-bank"},
				cutout: true,
				dataTable: {},
				data: [],

				root: "",

				bool: {
					load: false
				},

				table: "#list",

				fields: {

					"instituicao": "id,nome,telefone,logradouro,cep,numero,complemento,bairro,cidade,estado,descricao",

					"alunos": "id,nome,data_nascimento,rg_cpf,instituicao,responsavel,email,telefone,celular,logradouro,cep,numero,complemento,bairro,cidade,estado,descricao",

					'outros': 'id,name,last_name,email,password,cpf,sexo,data_nascimento,telefone,celular,pin,termos,avatar,address'

				},

			}
		},

		mounted() {
			if( this.cutout != false )
				//this.list_table()

			this.root = this.$root.$refs.accounts
			
			this.ListDataTable()
			this.GetRowsDataTable()

		},

		methods: {
			
			ListDataTable() {

				var self = this

				this.dataTable = $(this.table).DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					//initComplete: this.DataTableComplete(),
					drawCallback: function() {
                        $(".select").off("click").on("click", function( event ) {
							event.preventDefault()
							
							self.AddDataFormModel( $(this).attr("ref") )

							if( self.root.type == 'outros' ) {
								self.root.EnableButton([3]);
								return false;
							}

                            self.root.EnableButton([1, 2, 3]);
                            //self.form.Error([]) // limpar mensagem de error

                        })
                    }
				})                

			},


			GetRowsDataTable() {

                this.bool.load = true
				var type = this.root.type // tipo de seção

                var src = this.$resource( this.root.host +"/"+ type  )
                src.query().then(function( res ) {
                    
                    var data = res.data,
						list = []

                    for( var i = 0; i<data.length; i++ ) {  
                        this.fields[type].split(",").forEach(function(item, x) {

                            list[i] = Object.assign({}, list[i], {[item.trim()]:data[i][item]})

                        }) 
                    }

                    this.data = list
                    this.AddRowsDataTable(list)
                    this.bool.load = false

                })

            },

			AddRowsDataTable( data ) {

				var self = this,
					field = 'nome';
				
				if( data.length == 0 )
					data = this.data

				if( this.root.type == 'outros' ) {
					var field = 'name';
				}

				data.forEach(function(item, i) {
					
					// if( item.nome.length || item.name.length == 0 ) {	
					// 	item.nome = 'undefined';
					// }

					self.dataTable.row.add(
						[
                            ["<label><a class=\"select\" ref=\"",
                                item.id,
                                "\" href=\"#\">",
                                item[field],
                            "</a></label>"].join("")
                        ]
					).draw(false)

				})

			},

			AddDataFormModel( id ) {

				var self = this,
					forms = this.root.$refs.forms,
					type = this.root.type;

				forms.$refs[type].model = {};
				forms.$refs[type].error = {};
				
                this.data.forEach(function(item, i) {
                    if(item.id == id){
                        self.fields[type].split(",").forEach(function(field, x) {
                        	
                        	if( field == 'data_nascimento' ) {
                        		item[field] = self.DateChange(item[field]);
                        	}

                            forms.$refs[type].model[field] = item[field]

                        })   
                    }
                })

			},

			DateChange( date ) {
				return date.split('-').reverse().join('/');
			},

			RefreshDataTable() {

                this.data.length = 0
                this.dataTable.clear().draw();

                this.GetRowsDataTable()

            },

			// --------------------------

			list_table() {
				
				var self = this, data = [], accounts = this.$root.$refs.accounts
	
				this.dataTable = jQuery("#list").DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					initComplete: this.dataTableComplete(),
					drawCallback: function() {
						$(".select").off("click").on("click", function( event ) {
							event.preventDefault()
							
							var id = $(this).attr("ref")
							var form = accounts.$refs.forms.$refs[ accounts.form ]

							accounts.change_button( null )
							form.error = []
							
							if( accounts.form == "instituicao" ) {
								self.add_values_form({
									fields: "id,nome,telefone,taxa,descricao",
									id: id,
									store: form.store
								})
							}

							if( accounts.form == "alunos" ) {
								self.add_values_form({
									fields: "id,nome,data_nascimento,rg_cpf,instituicao,responsavel,email,telefone,celular,descricao",
									id: id,
									store: form.store
								})
							}

							if( accounts.form == "outros" ) {
								self.add_values_form({
									fields: "id,nome,email,telefone,celular,descricao",
									id: id,
									store: form.store
								})
							}

						})
					}
				})

        		data = JSON.parse(accounts.data.replace(this.clear_json.join("\n"), "").trim())

				for( var i in data ) {

					this.dataTable.row.add( [
						["<label><a class=\"select\" ref=\"", 
							data[i].id,
							"\" href=\"#\">", 
							data[i].nome,
						"</a></label>"].join("")
					] ).draw(false)

				}

			},

			dataTableComplete() {
				this.loader = false
			},

			add_values_form( args ) 
			{
				var data = [], fields = [], list = []
				var accounts = this.$root.$refs.accounts // component

				data = JSON.parse(accounts.data.replace(this.clear_json.join("\n"), "").trim())
				fields = args.fields.split(",")
				fields.push("logradouro", "cep", "numero", "complemento", "bairro", "estado", "cidade")
			
				if( this.cutout != true ) 
					data = this.data
				
				for( var i in data ) {

					if( accounts.form == "alunos" ) 
						data[i].data_nascimento = ((data[i].data_nascimento.split("-")).reverse()).join("/")

					if( args.id == data[i].id )
						list = data[i]

				}

				fields.forEach(function(item, index) {
					args.store[item] = list[item]
				})

			},

			/*
				metodo: refresh_rows
				resposavel pela execução: modulo index.vue do componente accounts
				metodo de suporte na execução: show() componente accounts
			*/
			refresh_rows() {
				
				var dataTable = this.dataTable
				
				this.loader = true

				if( this.cutout !== true ) {

					dataTable.clear().draw()
					
					for( var i in this.data ) {

						dataTable.row.add( [
							["<label><a class=\"select\" ref=\"", 
								this.data[i].id,
								"\" href=\"#\">", 
								this.data[i].nome,
							"</a></label>"].join("")
						] ).draw(false)

					}
				}

				this.loader = false
				

			},

		}

	}
</script>

<style> .loader{ padding: 60px 0; } </style>