<template lang="html" src="../../views/politica/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

	import PulseLoader from "../plugins/vue-spinner.vue"

	export default {

		components: { PulseLoader },

		data() {
			return {

				title:  "Politicas",

				// components
				resource: "",
                root: "",
                form: "",
                perso: "",
                campos: "",

				// booleano
				bool: {
					load: true,
				},

                table: "#list",
				dataTable: {}, // API

				// campos da base de dados
				fields: "id,nome,tipo,quantidade,campos,descricao,list",

				// model
				data: []

			}
		},

		mounted() {

			this.root = this.$root.$refs.policy
            this.form = this.root.$refs.form
            this.perso = this.form.$refs.perso
            this.campos = this.form.$refs.campos

            this.resource = this.$resource( this.root.host  )

			this.ListDataTable() // jquery Datatable...
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

                            self.form.CleanModel()

                            self.AddDataFormModel( $(this).attr("ref") )
                            self.root.EnableButton([1, 2, 3])
                            self.form.Error([]) // limpar mensagem de error

                        })
                    }
				})                

			},

			GetRowsDataTable() {

                this.bool.load = true

                var src = this.$resource( this.root.host +"/show"  )
                src.query().then(function( res ) {
                    
                    var data = res.data,
						list = []

                    for( var i = 0; i<data.length; i++ ) {  
                        this.fields.split(",").forEach(function(item, x) {
                            list[i] = Object.assign({}, list[i], {[item]:data[i][item]})
                        }) 
                    }

                    this.data = list
                    this.AddRowsDataTable(list)
                    this.bool.load = false

                })

            },

			AddRowsDataTable( data ) {

				var self = this

				if( data.length == 0 )
					data = this.data
                
				data.forEach(function(item, i) {

					self.dataTable.row.add(
						[
                            ["<label><a class=\"select\" ref=\"",
                                item.id,
                                "\" href=\"#\">",
                                item.nome,
                            "</a></label>"].join("")
                        ]
					).draw(false)

				})

			},

            AddDataFormModel( id ) {

                var myself = this

                this.data.forEach(function(item, i) {
                    if(item.id == id){
                        myself.fields.split(",").forEach(function(field, x) {
                            myself.form.model[field] = item[field]
                        })   
                    }
                })

                if( this.form.model.list.length != 0 ) {
                    this.form.model.list = JSON.parse(this.form.model.list)
                }else{
                    this.form.model.list = []
                }

                this.perso.quantidade = []
                
                for( var i = 0; i < this.form.model.quantidade; i++ ) {
                    this.perso.quantidade.push(i)
                }

                this.perso.Construct( id )

            },

            RefreshDataTable() {

                this.data.length = 0
                this.dataTable.clear().draw();

                this.GetRowsDataTable()

            },

			DeleteRowDataTable( id ) {
                this.dataTable.row( $(this.table).find("a[ref='"+ id +"']").parents("tr") ).remove().draw()
            },

            DataTableComplete() {
				this.bool.load = false
			},

		}

	}
</script>

