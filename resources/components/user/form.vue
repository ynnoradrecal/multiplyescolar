<template lang="html" src="../../views/usuarios/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

    import PulseLoader from "../plugins/vue-spinner.vue"
    import Avatar from "./avatar.vue"
    import Upload from "./upload.vue"

    export default {

        components: { PulseLoader, Avatar, Upload }, 

        props: ['host', 'url'],

        data() {
            return {

                resource: "",
                root: "",
                list: "",
                avatar: "",

                model: {},

                bool: {
                    grupo: false,
                    load: false
                },
                
                error: [],

                grupos: "",

            }
        },

        mounted() {


            this.root = this.$root.$refs.user;
            this.list = this.root.$refs.list;
            this.avatar = this.root.$refs.form.$refs.avatar;

            this.resource = this.$resource( this.host +"/init" );
            
        },

        methods: {

            save( arg ) {

                this.bool.load = true

                this.resource.save( {'methods':'__save', 'model':this.model} ).then(function( response ) {

                    if(response.data.status == 'warning') {
                        this.$swal("Warning! ",  response.data.message, 'warning'); // alert sucesso
                        this.bool.load = false;
                        return false;
                    }

                    this.$swal("Sucesso! ",  this.model.nome +" salvo.", 'success') // alert sucesso

                    // refresh na tabela
                    this.refreshDataTable()

                    // reset "load", "error"
                    this.bool.load = false
                    this.error = [] 
                    this.clearModel()

                }, function( response ) { // error!
                    
                    this.storeErro( response.data );

                    this.bool.load = false

                })

            },

            put() {

                this.bool.load = true
                
                this.resource.save( {'methods':'__update', 'model':this.model} ).then(function( response ) {

                    if( response.data.status == 'false' ) {
                        this.bool.load = false
                    }

                    this.$swal('Sucesso! ', this.model.nome +' altualizado.', 'success');
                    
                    // refresh na tabela
                    this.refreshDataTable()

                    this.bool.load = false
                    this.model.admin.senha = ""

                }, function( response ) { // error!

                    this.storeErro( response.data );
                    this.bool.load = false
                })

            },

            destroy() {
                
                var self = this

                this.$swal({
                    
                    "title": "Deseja excluir esse usuário?",
                    "type": 'warning',
                    "showCancelButton": true,
                    "closeOnConfirm": false,
                    "cancelButtonText": "Cancelar",
                
                }).then(function() { 
                    
                    self.bool.load = true

                    self.resource.save( {'methods':'__delete', 'id':self.model.id} ).then(function( response ) {
                        
                        self.$swal("Removido! ", self.model.nome +" removido com sucesso.", "success");

                        self.root.$refs.list.deleteRowDataTable( self.model.id )
                        self.root.enableButton([0])
                        self.clearModel()
                        self.bool.load = false

                    }, function( response ) {

                        self.bool.load = false
                        self.adminSenhaError( response.data );

                    })


                })

            },
            
            refreshDataTable() {
                this.list.data.length = 0
                this.list.dataTable.clear().draw();
                this.list.getRowsDataTable()
            },

            storeErro( data ) {
                
                var self = this
                    self.error = [];

                console.log(data);

                Object.keys(data).forEach(function(item, i) {
                    self.error[ item.replace("model.", "") ] = [data[item][0]]
                })

            },

            clearModel() {

                for( var item in this.model ) {
                    if( item == "admin" ) {
                        this.model.admin.senha = ""
                    }else{
                        this.model[item] = item == "foto" ? {url: ""} : ""
                    }
                }

            },

            adminSenhaError( data ) {
                this.$swal({ "title": data.title, "text": data.message, "type": data.alert, })
            },

            // listando todos os grupos
            getGrupos() {

                this.bool.grupo = true

                this.resource.save( {"methods": "getGroup"} ).then(function( response ) {

                    this.bool.grupo = false
                    this.grupos = response.data

                })

            },

            OpenModal( el ) {
                $( el ).modal('show')
            },

        },

    }

</script>
<style> .loader_form{ position: relative; top:8px; } </style>