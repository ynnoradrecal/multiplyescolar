<template lang="html" src="../../../views/contas/forms/instituicao.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import AwesomeMask from 'awesome-mask';

export default {

    directives: {
        'mask': AwesomeMask
    },

    props: ["id", "error"],

    data() {

        return {
            
            title: 'Instituição',

            maskpho: '(99) 9999-9999',
            maskcel: '(99) 9 9999-9999',

            status: true, 

            list: { estados:[], cidades:[] },

            model: {
                cep: "",
                telefone: '',
            },

            root: "",
            forms: "",

            //cep: '09950-520',
			endereco: {},
			naoLocalizado: false

        }

    },

    mounted() {

        this.root = this.$root.$refs.accounts
        this.forms = this.root.$refs.forms

    },


    methods: {
        getAddressCep() {

			var self = this;
      
			self.naoLocalizado = false;
			
			if(/^[0-9]{5}-[0-9]{3}$/.test(this.model.cep)){
				$.getJSON("https://viacep.com.br/ws/" + this.model.cep + "/json/", function(endereco){
					if(endereco.erro){
						self.endereco = {};
						$("#inputLogradouro").focus();
						self.naoLocalizado = true;
						return;
					}

					self.endereco = endereco;

					self.model = Object.assign({}, self.model, {
                        "cep":endereco.cep,
                        "logradouro":endereco.logradouro,
                        "cidade":endereco.localidade,
                        "bairro":endereco.bairro +" "+ endereco.complemento,
                        "estado":endereco.uf


                    })

					//$("#inputNumero").focus();

				});
			}

		}
    }

}
</script>


