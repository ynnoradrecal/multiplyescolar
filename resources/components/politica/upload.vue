<template lang="html" src="../../views/politica/upload.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>
	
	import Dropzone from "vue2-dropzone"

	export default {

		name: 'upload',

        components: {
            Dropzone
        },

        props: ['index', 'host'],

		data() {
			return {

                acceptedFileTypes: "image/*",

                headers: {
                    "X-CSRF-TOKEN": Laravel.csrfToken
                },

                thumbnailHeight: 160,
                thumbnailWidth: 160,

                lang: {
                    "dictRemoveFile":"Excluir Foto!",
                    "dictDefaultMessage":"<h3>Solte os arquivos em qualquer lugar para fazer o upload</h3><small>ou</small><div class='btn_upload'>Selecionar arquivos</div><br><small>O tamanho máximo do arquivo de upload: 1 MB.</small>",
                    "dictResponseError":"Server responded with {{statusCode}} code.",
                    "dictCancelUpload":"Cancelar Upload!",
                    "dictMaxFilesExceeded":"You can not upload any more files."
                },

               	images: [],

			}
		},

		methods: {   

			ShowSucess(file, res) {

				var data   = res.data,
					parent = this.$parent.$parent.$refs.perso,
					i      = this.index

				//parent.model[i].path = data.path

                parent.model[i].images.push({
                	"name": data.name,
                	"image": data.path +'/'+ data.image
                })

            },

          //   RemoveFile(file, error, xhr) {

          //       var $root  = this.$root.$refs.policy,
          //       	parent = this.$parent.$parent.$refs.perso,
        		// 	i      = this.index,
        		// 	myself = this

        		// parent.model[i].images.forEach(function(item, j, list) {
        		// 	if( item.name == file.name ) {

        		// 		myself.$resource( $root.host +"/upload" )
          //               	.save( {"methods":"destroyFileUpload", id:"", image:list[j].image} )

          //               list.splice(j, 1)

        		// 	}
        		// })	

          //   },

		}

	}

</script>