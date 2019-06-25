<template lang="html" src="../../views/fotos/folder.html"></template>
<style lang="sass" src="../../assets/admin/sass/components/fotos.scss"></style>
<script>

    var PulseLoader = require('vue-spinner/dist/vue-spinner.min').PulseLoader;

    export default {

        props: ["product", 'url'],

        components: { PulseLoader },

        data() {
            return {

                root: "",

                swal: {
                    setting: {
                        title: 'Deseja excluir a foto?', 
                        text: 'A foto sera permanentemente apagada do repositório.',
                        type: 'info', 
                        confirmButtonColor: '#169F85', 
                        cancelButtonColor: '#d9534f', 
                        confirmButtonText: 'Excluir Foto!',
                        showCancelButton: true,
                        showLoaderOnConfirm: true
                    }
                },

                spinner: {
                    color: "#009cde",
                },

                bool:{
                    load: true,
                },

                images: [],

            }
        },

        mounted() {
            
            this.root = this.$root.$refs.fotos
        },

        methods: {

            GetFotos() {

                this.images = [];
                this.bool.load = true;

                this.$resource( this.root.host +"/init" )
                    .save( {
                        "methods":"GetFotos", 
                        "id":this.product.id
                    } ).then(function( res ) {

                        this.images = res.data

                        for( var i in this.images ) {

                            var split = this.images[i].url.split('/').pop().split('.'),
                                name  = this.images[i].name,
                                ext   = split[1],
                                thumb = '/uploads/repositorio/'+ this.images[i].produto_id +'/thumb/' + split[0] +'.'+ split[1];

                            this.images[i] = Object.assign({}, this.images[i], {
                                "name": name,
                                "ext": ext,
                                'thumb': thumb
                            })

                        }

                        this.WaterFall()
                        this.bool.load = false

                    })

            },

            WaterFall() {
                $('#waterfall').NewWaterfall({

                    // width of grid item
                    width: 250,

                    // refresh delay
                    delay: 60,

                    // By default, the plugin will add the class 'show' to grid item when in viewport
                    // setting the options to true will remove the class when out of the viewport
                    repeatShow: false
                
                });
            },

            DelImage( i ) {

                var self = this;

                this.$swal( this.swal.setting ).then(function() {
                    self.$resource( self.root.host +'/init' )
                        .save( { 
                            'methods': 'DelImage', 
                            'data': {
                                'id':  self.images[i].id, 
                                'url': self.images[i].url, 
                            }
                        } ).then(function( res ) {
                            self.images.splice(i, 1);
                        });
                });

            },

            Dimension( url, i ) {

                var img = new Image();

                img.addEventListener('load', function() {

                    console.log(img.width +' - '+ img.height);

                })
                
                img.src = url;


            },

            AddFotos() {

                this.root.OpenWindow( 'upload' )

            },

        }

    }
</script>
