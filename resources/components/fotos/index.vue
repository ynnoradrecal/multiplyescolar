<template lang="html" src="../../views/fotos/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

    import List from "./list.vue"
    import Upload from "./upload.vue"
    import Folder from "./folder.vue"

    export default {

        name: 'index',

        props: ['url', 'host'],

        components: { List, Upload, Folder },

        data() {
            return {

                title: "Fotos",

                button: { "save":true, "put":false, "add":false, "destroy":false },

                window: "",

                windows: {
                    list: true,
                    folder: false,
                    upload: false
                },

                product: {
                    id: "",
                    nome: "",
                },

                swal: {
                    setting: {
                        title: 'Deseja excluir todas as fotos?', 
                        text: 'Todas as fotos serão apagados permanentemente do repositório.',
                        type: 'warning',
                        showCancelButton: true, 
                        confirmButtonColor: '#169F85', 
                        cancelButtonColor: '#d9534f', 
                        confirmButtonText: 'Excluir Todas as Fotos!'
                    }
                },

                // components
                list: {},


            }
        },

        mounted() {

            this.list = this.$root.$refs.fotos.$refs.list

        },

        methods: {

            Save() {
                this.$root.$refs.fotos.$refs.upload.SendUpload()
            },

            DeleteAllRepository( i, id ) {

                var self = this;

                this.$swal( this.swal.setting ).then(function() {
                    self.$resource( self.host +'/init' )
                        .save( { 
                            'methods': 'DelAllRepository', 
                            'data': {
                                'id': id, 
                            }
                        } ).then(function( res ) {
                            self.list.GetRowsDataTable()
                        });
                });

            },

            OpenWindow( window ) {

                var myself = this

                Object.keys(this.windows).forEach(function( item, i ) {

                    myself.windows[item] = false

                    if( window == item ) {

                        myself.windows[item] = true
                        myself.window = item

                    }

                }) 

            },

            Back() {

                // resolvendo bug de delete no component upload
                if( this.window == "upload" ) {
                    this.$root.$refs.fotos.$refs.upload.images = []
                }

                this.OpenWindow( "list" )

            }

        }

    }
</script>