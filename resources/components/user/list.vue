<template lang="html" >
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-cube"></i> Usuários</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-xs-12">
                <div v-show="bool.load">
                    <pulse-loader class="loader text-center"></pulse-loader>
                </div>
                <div v-show="!bool.load">
                    <table id="list" class="table table-striped table-bordered" width="100%">
                        <thead style="display:none;">
                            <tr class="">
                                <td class=""></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>  
        </div>
    </div>
</template>
<script>

    import PulseLoader from "../plugins/vue-spinner.vue"

    export default {

        components: { PulseLoader },

        props: ['host'],

        data() {
            return {

                table: "#list",
                
                root: "",
                resource: "",
                form: "",

				dataTable: {},

                bool: {
                    load: true,
                },
				
				data: [],

            }
        },

        mounted() {

            this.root = this.$root.$refs.user
            this.form = this.root.$refs.form
            this.resource = this.$resource( this.host +"/init" )

            this.listDataTable()
            this.getRowsDataTable()

        },

        methods: {

            listDataTable() {

				var self = this

				this.dataTable = $(this.table).DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					//initComplete: this.dataTableComplete(),
					drawCallback: function() {
                        $(".select").off("click").on("click", function( event ) {
                            event.preventDefault()
                            
                            self.addDataModelForm( $(this).attr("ref") )
                            self.root.enableButton([1, 2, 3])

                            self.form.error = []
                            
                        })
                    }
				})                

			},

            getRowsDataTable() {

                this.bool.load = true

                this.resource.get( {"methods":'__show'} ).then(function( response ) {
                    
                    var data, list = [], field

                    field = "id,nome,email,password,foto,descricao"
                    data = response.data
                    list = []

                    for( var i = 0; i<data.length; i++ ) { 

                        list[i] = Object.assign({}, list[i], {["confirmar"]:data[i]["password"]})

                        field.split(",").forEach(function(item, x) {
                            list[i] = Object.assign({}, list[i], {[item]:data[i][item]})
                        }) 

                    }

                    this.data = list
                    this.addRowsDataTable(list)
                    
                    this.bool.load = false

                })

            },

            addRowsDataTable( data ) {

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

            addDataModelForm( id ) {
                
                var self = this
                var fields = ['id', 'nome', 'email', 'password', 'confirmar', 'foto', 'descricao']

                self.form.model = {};

                this.data.forEach(function(item, i) {
                    if(item.id == id){
                        
                        fields.forEach(function(field, x) {

                            if( field == 'foto' && item.foto != '' ) {

                                self.form.model = Object.assign({}, self.form.model, {
                                    'small': [{
                                        'local': item.id,
                                        'path':  '/uploads/usuarios',
                                        'thumb': item[field]
                                    }]
                                })

                            }else{
                                self.form.model[field] = item[field]
                            }                            

                        })   

                    }
                })

            },

            addStoreToDataTable( id, object ) {
                
                object["id"] = id;

                this.data.push( object )
                this.addRowsDataTable([object])

            },

            deleteRowDataTable( id ) {
                this.dataTable.row( $(this.table).find("a[ref='"+ id +"']").parents("tr") ).remove().draw()
            },

            dataTableComplete() {
				this.bool.load = false
			},

        },

    }

</script>