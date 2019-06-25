<template lang="html" src="../../../views/contas/forms/alunos.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import AwesomeMask from 'awesome-mask';

export default {

    directives: {
        'mask': AwesomeMask
    },

    props: ['error'],

    data() {
        return {

            title: 'Alunos',

            status: false,
            
            // list: { estados:[], cidades:[], instituicao:[] },
           
            list_instituicoes: [],

            model: {
                cep: '',
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

        this.get_instituicao();

    },

    methods: {

        get_instituicao() {

            var host = this.root.host,
                src  = this.$resource( host +"/init" );

            if( this.list_instituicoes.length == 0 ) {
                src.save({'methods':'__get_all_instituicao'}).then(function( res ) {
                    this.list_instituicoes = res.data
                })
            }

        },

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