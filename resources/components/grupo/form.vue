<template lang="html" >
    <div class="col-md-7 col-dm-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-cube"></i> {{ title }}</h2>
                <pulse-loader v-show="bool.load" class="loader_form pull-right"></pulse-loader>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group" v-bind:class="{'has-error':error.nome}">
                            <label for="">Nome</label>
                            <input class="form-control" placeholder="..." type="text" v-model="store.nome">
                            <span class="help-block" v-for="error in error.nome">{{ error.replace("post.nome", "Nome") }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{'has-error':error['admin.senha']}">
                            <label for="">Senha Administrador</label>
                            <input class="form-control" placeholder="..." type="password" v-model="store.admin.senha">
                            <span class="help-block" v-for="error in error['admin.senha']">{{ error.replace("post.admin.senha", "Senha Administrador") }}</span>
                        </div>

                        <fieldset>
                            <legend>Descrição</legend>
                            <div class="form-group" >
                                <textarea class="form-control" rows="3" placeholder="Descrição..." v-model="store.descricao"></textarea>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Nível de Acesso</legend>
                            <div v-show="bool.tree">
                                <pulse-loader class="loader text-center"></pulse-loader>
                            </div>
                            <div class="error" v-bind:class="{'has-error':error.tree}">
                                <span class="help-block" v-for="error in error.tree">{{ error }}</span>
                            </div>

                            <item class="tree" ref="tree" :model="model"></item>

                        </fieldset>
                    </fieldset>
                </form>
                
            </div>
        </div>
    </div>
</template>
<script>

    import Item from "./item.vue"
    import PulseLoader from "../plugins/vue-spinner.vue"

    export default {

        components: { Item, PulseLoader }, 

        data() {
            return {

                title: "Novo Grupo",
                
                bool: {
                    load: false,
                    tree: true,
                },

                error: [],
                model: [],

                resource: "",
                root: "",
                form: "",

                store: {
                    id: "",
                    nome: "",
                    descricao: "",
                    tree: {
                        "painel":{
                            "titulo": "Painel",
                            "ponteiro": "1",
                            "status": true
                        }
                    },
                    admin: {
                        senha: ""
                    },
                }

            }
        },

        mounted() {

            this.root = this.$root.$refs.grupo
            this.form = this.root.$refs.form

            this.resource = this.$resource( this.root.host +"/init" )
            
            this.resource.save( {"methods":"getTree"} ).then(function( response ) {
                this.model = JSON.parse( response.data[0].tree )
                this.bool.tree = false
            })

        },

        methods: {

            options( methods ) {
                return {
                    "methods": methods, 
                    "post": this.store
                }
            },

            save( arg ) {

                var dataTable = this.root.$refs.list
                this.bool.load = true

                this.resource.save( this.options("save") ).then(function( response ) {

                    this.$swal("Sucesso! ",  this.store.nome +" salvo.", 'success') 

                    dataTable.rowsDataTable([
                        {
                            "id": response.data.id,
                            "nome": this.store.nome,
                            "descricao": this.store.descricao,
                            "tree": this.store.tree
                        }
                    ])
                    
                    this.form.$refs.tree.resetICheck( Object.keys( this.store.tree ) )
                    
                    this.resetStore()
                    this.Erro([])

                                        

                }, function( response ) {
                    this.Error( response.data )
                })

            },

            put() {

                this.bool.load = true
                
                this.resource.save( this.options( "put" ) ).then(function( response ) {

                    this.$swal('Sucesso! ', this.store.nome +' altualizado.', 'success')
                    
                    this.root.$refs.list.cellDataTable( this.store.id, this.store.nome )
                    this.root.$refs.list.upDataList( this.store.id, response.data )

                    this.bool.load = false

                }, function( response ) {
                    this.storeErro( response.data )
                    this.bool.load = false
                })

            },

            destroy() {
                
                var self = this

                this.$swal({
                    
                    title: 'Deseja realmente deletar?', text: "Grupo "+ this.store.nome,
                    type: 'warning',
                    showCancelButton: true, confirmButtonColor: '#169F85', cancelButtonColor: '#d9534f',
                    confirmButtonText: 'Sim, Deletar!'

                }).then(function() {
                    
                    self.load = true

                    self.resource.save( {"methods": "destroy", "id": self.store.id} ).then(function( response ) {

                        self.$swal("Removido! ", this.store.nome +" removido com sucesso.", "success")
                        this.root.$refs.list.deleteRowDatable( self.store.id )
                        self.load = false

                    })

                })

            },

            Error( data ) {

                if(data.length == 0) {
                    this.error.length = 0
                }else{
                    
                    for( var item in data ) {
                        this.error[ item.replace("post.", "") ] = [data[item][0]]
                    }

                }

                 this.bool.load = false

            },
  
            resetStore() {
                this.store = { "id":"", "nome": "", "descricao": "", "tree": {} }
            }

        },

    }

</script>
<style> .loader_form{ position: relative; top:8px; } </style>