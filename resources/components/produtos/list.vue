<template lang="html" src="../../views/produtos/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/produtos.scss"></style> -->
<script>

	import PulseLoader from "../plugins/vue-spinner.vue"

	export default {

		components: { PulseLoader },

		data() {
			return {

				title:  "Repositório",

				// components
				resource: "",
				root: "",
				form: "",

				// booleano
				bool: {
					load: true,
				},

				table: "#list",
				dataTable: {}, // API

				// campos da base de dados
				fields: "id,delivery,event_id,aluno_id,instituicao_id,nome,thumb_small,pin,status,foto_unit_val,regras,descricao,policys",

				// model
				data: []

			}
		},

		mounted() {

			this.root = this.$root.$refs.product
            this.form = this.root.$refs.form

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

                            self.AddDataFormModel( $(this).attr("ref") )
                            self.root.EnableButton([1, 2, 3])

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

			AddDataFormModel( id ){

				var self = this,
					rules = ["regras", "policys", 'delivery'],

					// components
					_regras   = self.form.$refs.regras,
					_policy   = self.form.$refs.policy,
					_delivery = self.form.$refs.entrega,
					_form     = self.form;

				$('input[type="checkbox"]').iCheck('uncheck');

				_form.model.small = '';

                this.data.forEach(function(item, i, list) {


                    if(item.id == id){

                        self.fields.split(",").forEach(function(field, x) {
							
                        	if( field == "status" && item[field] == 1 ) {
								$('input[name="status"]').iCheck('check')
							}

							if(rules.indexOf(field) == -1) {
								_form.model[field] = item[field]

							}else{

								if(field == "policys") {
									_policy.AddPolicysModel( item[field] )
								}

								if(field == 'delivery') {
									_delivery.AddDeliveryModel( item[field], item.instituicao_id );
								}

								if(field == "regras") {
									_regras.AddRules(item[field])
								}

							}

							if( field == 'thumb_small' && item['thumb_small'] !== '' ) {

								self.form.model = Object.assign({}, self.form.model, {
                    				'small': [{
                    					'local': id +'/thumb_small',
                    					'thumb': item['thumb_small']
                    				}]
                				})
							}
								

                        })  

                    }

                });

			},

			RefreshDataTable() {

                this.data.length = 0
                this.dataTable.clear().draw();

                this.GetRowsDataTable()

            },

			DataTableComplete() {
				this.bool.load = false
			},

		}

	}

</script>