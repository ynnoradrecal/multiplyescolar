<template lang="html" src="../../views/fotos/upload.html"></template>
<style lang="sass" src="../../assets/admin/sass/components/fotos.scss"></style>
<script>

    import Dropzone from 'vue2-dropzone'

    export default {

        name: 'upload',

        components: {
            Dropzone
        },

        props: ["product", 'host'],

        data() {
            return {

                root: "",

                acceptedFileTypes: "image/*",
                thumbnailHeight: 165,
                thumbnailWidth: 165,
                headers: {
                    "X-CSRF-TOKEN": Laravel.csrfToken
                },

                lang: {
                    "dictRemoveFile":"Excluir Foto!",
                    "dictDefaultMessage":"<h3>Solte os arquivos em qualquer lugar para fazer o upload</h3><small>ou</small><div class='btn_upload'>Selecionar arquivos</div><br><small>O tamanho máximo do arquivo de upload: 1 MB.</small>",
                    "dictResponseError":"Server responded with {{statusCode}} code.",
                    "dictCancelUpload":"Cancelar Upload!",
                    "dictMaxFilesExceeded":"You can not upload any more files."
                },

                images: [],

                progress: 0,

            }
        },

        methods: {

            Mounted() {

                var self = this, __dropz, tt_file;

                self.root = self.$root.$refs.fotos  
                __dropz   = self.root.$refs.upload.$refs.dropz;

                
                __dropz.dropzone.on('addedfile', function() {
                    console.log(__dropz.dropzone.files.length);
                })

                __dropz.dropzone.on('success', function(file) {

                });

                __dropz.dropzone.on('totaluploadprogress', function (total, totalBytes, totalBytesSent) {
                    //self.progress = progress;
                    //console.log( total )
                })

                //console.log( this.root.$refs.upload.$refs.dropz.url = this.host )

            },

            ShowSucess(file, response) {
                this.images.push( response.image )
            },

            RemoveFile(file, error, xhr) {

                var id, src

                if( this.images.length != 0 ) {

                    this.images.forEach(function(image, i) {
                        if( file.name == image.name ) {
                            id = image.id
                        }
                    })

                    this.$resource( this.root.host +"/init" )
                        .save( {"methods":"RemoveFile", "id":id} )

                }

            }

        }

    }
</script>