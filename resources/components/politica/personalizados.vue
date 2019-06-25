<template lang="html" src="../../views/politica/personalizados.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

    import AwesomeMask from 'awesome-mask'

    import Upload from "./upload.vue"

    export default {

        components: {
            Upload
        },

        directives: {
            'mask': AwesomeMask
        },

        data() {

            return {

                host: '',
                url: '',

                root: "",
                form: "",
                list: "",

                quantidade: [],
                numberInglish: ["One", "Two", "Three", "Four", "Five", "Six", "Sev", "Eight", "Nine", "Ten", "Eleven", "Twelve"],

                campos: [], 
                model:  [], 

                error: [],
      
                // booleano
                bool: {
                    image:  false,
                    anexar: false,
                    remove: false,
                    load:   false,
                    error:  false // Error se todos os campos do criado nao forem preenchido
                },

            }

        },


        mounted() {

            this.root = this.$root.$refs.policy;
            this.form = this.root.$refs.form;
            this.list = this.root.$refs.list;

            this.host = this.root.host;
            this.url  = this.root.url;

        },

        methods: {

            Construct( id ){

                var list   = this.quantidade,
                    self = this,
                    data   = {}

                self.model = []

                list.forEach(function(item, i) {
                    self.model.push(Object.assign({}, "", {
                        title: "",
                        path: "",
                        images: [],
                        price: "",
                        desc: "",
                        height: "",
                        width: "",
                        length: ""
                    }))
                })

                data = this.ProofDataForId( id )

                if( data.list.length != 0 ) {
                    this.AddDataModel( JSON.parse( data.list ) ) 
                }


            },

            // Model

            ProofDataForId( id ) {

                var data

                this.list.data.forEach(function(item, i, list) {
                    if( item.id == id ) {
                        data = list[i]
                    }
                }) 

                return data

            },

            AddDataModel( data ) {

                var myself = this,
                    fields = 'title,path,images,price,desc,height,width,length';

                Object.keys(data).forEach(function(i) {
                    fields.split(',').forEach(function(field) {
                        myself.model[i][field] = data[i][field]
                    })
                })

            },  

            // Grids

            AddSingleGrid() {

                var self = this, tt = this.quantidade.length,
                    field = 'title,path,images,price,desc,height,width,length';

                field.split(',').forEach(function(field, i, list) {
                    self.model[tt] = Object.assign({}, self.model[tt], {[field]:''});
                    if( field == 'images' ) {
                        self.model[tt][field] = [];
                    }
                });

                this.quantidade.push(tt);

                this.form.model.quantidade = tt + 1;

                // var struct = this.model[this.model.length - 1],
                //     new_struct = {}

                // Object.keys( struct ).forEach(function(field, i, arr) {
                //     new_struct = Object.assign({}, new_struct, {[field]:""})
                // })

                // new_struct.id = struct.id + 1

                // this.model.push( new_struct )

                // this.form.model.quantidade = this.form.model.quantidade + 1

                //this.error.push( new_struct )

            },

            DestroyGrid( index, title ) {

                this.quantidade.splice(index, 1)
                this.form.model.quantidade = this.form.model.quantidade - 1

                this.model.forEach(function(item, i, list){
                    if(item.title == title) {
                        list[i] = []
                    }
                })
                
            },

            // Images
            
            VerifyPathInImage( path, image ) {
            
                var tmp = image.split('/').splice(0, 3)
                
                if(tmp.join('/') == '/uploads/tmp') {
                    return image
                }else{
                    return path +'/'+ image 
                }

            },


            RemoveImage(i, args) 
            {

                // var tmp    = '/uploads/tmp',
                //     file   = args.image.split('/'),
                //     image  = file.pop(),
                //     src    = this.$resource( this.host +'/upload' )

    
                // if( file.join('/') == tmp ) {
                //     src.save({
                //         "methods":"destroyFileUpload", 
                //         "id":"", 
                //         "image":image
                //     }).then(function() {})
                // }

                this.model[i].images.splice(args.index, 1)

            },


            // Outros

            OpenModal( el ) {
                $( el ).modal('show')
            },

            Bool( arr ) {

                var self = this

                for( var item in this.bool ) {
                    this.bool[item] = arr.indexOf( item ) != -1 ? true : false
                }

            }, 

            Clean() {
                this.model = []
                this.error = []
            }

        }

    }
</script>
