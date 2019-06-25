<template lang="html" >
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-cube"></i> {{ title }}</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-xs-12">
                <div v-show="bool.load" class="text-center" style="width:100px;margin:0 auto;">
                    <dot :color="spinner.color" class="loader text-center"></dot>
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

    var Dot = require('vue-spinner/dist/vue-spinner.min').DotLoader;

    export default {

        components: { Dot },

        data() {
            return {

                title: "Grupos",

                table: "#list",

                root: "",

				dataTable: {},
                spinner: {
                    color: "#3498DB"
                },

                bool: {
                    load: true,
                },

				data: [],

            }
        },

        mounted() {
            this.listDataTable()
            this.getRowsTable()
        },

        methods: {

            listDataTable() {

				var self, root, data

				self = this
				this.root = this.$root.$refs.grupo // component

				this.dataTable = $(this.table).DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					//initComplete: this.dataTableComplete(),
					drawCallback: function() {
                        $(".select").off("click").on("click", function( event ) {
                            event.preventDefault()
                            
                            self.loadStore( $(this).attr("ref") )
                            self.root.enableButton([1, 2, 3])
                            
                        })
                    }
				})                

			},

            getRowsTable() {
                
                var resource = this.$resource( this.root.host +"/init" )

                resource.save( {"methods":"get"} ).then(function( response ) {
                    
                    var self = this, data = []
                    
                    response.data.forEach(function(item, i) {   
                        self.data.push({
                            id: item.id,
                            nome: item.nome,
                            descricao: item.descricao,
                            tree: JSON.parse( item.nivel )
                        })
                    })

                    this.rowsDataTable([])

                    this.bool.load = false

                })

            },

            rowsDataTable( data ) {

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

            cellDataTable( id, nome ) {
                
                this.dataTable.cell( $(this.table).find("a[ref='"+ id +"']").parents("td") )
                    .data( [
                        "<label><a class=\"select\" ref=\"", id,
                        "\" href=\"#\">", nome,
                        "</a></label>"
                    ].join("") ).draw()

            },

            loadStore( id ) {
                
                var form = this.$root.$refs.grupo.$refs.form, self = this

                this.data.forEach(function(item, i) {
                    
                    if(item.id == id){
                        
                        form.store = {
                            "id": item.id,
                            "nome": item.nome,
                            "descricao": item.descricao,
                            "tree": item.tree,
                        }

                        $('input').iCheck('uncheck');
                        form.$refs.tree.checkedInputTree(  Object.keys(item.tree) )

                    }
                })
            },

            upDataList( id, data ) {

                var self = this

                this.data.forEach(function(item, i) {
                    if( item.id == id ) {
                        self.data[i] = {
                            "nome": data.nome,
                            "descricao": data.descricao,
                            "tree": JSON.parse( data.nivel )
                        }
                    }
                })  

            },

            deleteRowDatable( id ) {
                this.dataTable.row( $(this.table).find("a[ref='"+ id +"']").parents("tr") ).remove().draw()
            },

            dataTableComplete() {
				this.bool.load = false
			},

        },

    }

</script>