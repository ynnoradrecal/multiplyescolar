<template lang="html" src="../../views/fotos/list.html"></template>
<style lang="sass" src="../../assets/admin/sass/components/fotos.scss"></style>
<script>

    var PulseLoader = require('vue-spinner/dist/vue-spinner.min').PulseLoader;

    export default {

        name: "list",

        components: { PulseLoader },

        data() {
            return {

                spinner: {
                    color: "#009cde",
                },

                bool: {
                    load: true
                },

                table: "#list",
                dataTable: {},

                // components
                root: "",
                form: "",
                folder: '',
                upload: '',

                fields: "id,pr_nome,ev_nome,al_nome,preco,status",
                data: []


            }
        },

        mounted() {

            this.root = this.$root.$refs.fotos
            this.folder = this.root.$refs.folder
            this.upload = this.root.$refs.upload

            //this.form = this.root.$refs.form

            this.ShowList()
            this.GetRowsDataTable()            

        },

        methods: {

            ShowList() {

                var self = this

				this.dataTable = $(this.table).DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					drawCallback: function() {

                        $('.window').off('click').on('click', function(event) {

                            event.preventDefault()

                            var id = $(this).attr("ref"), 
                                wind = $(this).attr('window')

                            if( wind != 'excluir' ) {
                                
                                self.root.OpenWindow( wind )
                            
                                self.data.forEach(function( item, i, list ) {

                                    if( item.id == id ){

                                        self.root.product.id = item.id
                                        self.root.product.nome = item.pr_nome

                                        if( wind == 'excluir' ) {
                                            self.root.DeleteAllRepository( i, item.id )
                                        }

                                    }

                                })

                                self.folder.GetFotos()

                                self.upload.$refs.dropz.removeAllFiles()

                            }else{

                                self.data.forEach(function( item, i, list ) {
                                    if( item.id == id ){
                                        self.root.DeleteAllRepository( i, item.id )
                                    }
                                })

                            }

                        })

                        $('[data-toggle="tooltip"]').tooltip()

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

				var self = this,
                    host = this.url +""+ this.root.host +"/anexo"

				if( data.length == 0 )
					data = this.data
                
				data.forEach(function(item, i) {
					self.dataTable.row.add(
						[
                            "#",
                            item.pr_nome,
                            item.ev_nome,
                            item.al_nome,
                            'R$ '+ item.preco.toLocaleString('pt-BR'),
                            item.status,
                            [

                                ['<div class="bt_action text-center">'],

                                ['<a href="#" class="btn btn-primary btn-xs window" window="folder" ref="'+ item.id +'" ',
                                'data-toggle="tooltip" data-placement="top" title="Visualizar">',
                                    '<i class="fa fa-folder"></i>',
                                '</a>'].join(''),

                                ['<a href="#" class="btn btn-info btn-xs window" window="upload" ref="'+ item.id +'" ',
                                'data-toggle="tooltip" data-placement="top" title="Upload">',
                                    '<i class="fa fa-upload"></i>',
                                '</a>'].join(''),

                                // ['<a href="#" class="btn btn-danger btn-xs window" window="excluir" ref="'+ item.id +'" ',
                                // 'data-toggle="tooltip" data-placement="top" title="Excluir">',
                                //     '<i class="fa fa-trash-o"></i>',
                                // '</a>'].join(''),

                                ['</div>']

                            ].join("")
                        ]
					).draw(false)

				})

			},

        }

    }

</script>