<template lang="html" src="../../../views/developer/forms/upload.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/fotos.scss"></style> -->
<script>
	
	import Dropzone from "vue2-dropzone";

	export default {

		name: 'upload',

        components: {
            Dropzone
        },

        props: ['host'],

		data() {
			return {

                // components
                form: '',

                acceptedFileTypes: "image/*",

                headers: {
                    "X-CSRF-TOKEN": Laravel.csrfToken
                },

                thumbnailHeight: 240,
                thumbnailWidth: 240,

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

        mounted() {

            var _root = this.$root.$refs.developer;
            this.form = _root.$refs.form.$refs['facebook'];

        },

		methods: {   

			ShowSucess(file, res) {

                var file = res.file;

                this.form.store = Object.assign({}, this.form.store, {
                    'file': [file]
                });

                this.form.button_image('delete');

            },

		}

	}

</script>