<template lang="html" src="../../views/contas/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import NavAccounts from "./nav-accounts.vue"
import List from "./list.vue"
import Forms from "./forms.vue"

export default {

    components: { NavAccounts, List, Forms },

    props: ['url', 'host'],

    data() {
        return {

            rowTable: ["<label><a class=\"select\" ref=\"", "\" href=\"#\">", "</a></label>"],

            title: "Instituição",
            form: "instituicao",
            error: [],
            list: { estados:[], cidades:[] },
            button: {save: true, delete: false, update: false, new: false},
            datatable: [],

            button: { "save":true, "put":false, "add":false, "destroy":false },

            type: "instituicao",

            forms: "",
        }
    },

    mounted() {

        this.forms = this.$root.$refs.accounts.$refs.forms

    },

    methods: {

        add() {

            this.EnableButton([0]);
            this.forms.form.model = {
                cep: '',
                telefone: ''
            };

            this.forms.form.error = {};

        },

        save() { this.forms.Store(); },
        put() { this.forms.Put(); },

        destroy() {
            
            this.forms.Destroy();

        },


        EnableButton( arr ) {   

            var myself = this

            Object.keys(this.button).forEach(function(item, i) {
                if( arr.indexOf(i) != -1 ) {
                    myself.button[item] = true
                }else{
                    myself.button[item] = false
                }
            })

        },

        CleanModel() {

            var self = this, 
                forms = this.$root.$refs.accounts.$refs.forms,
                tdc = ['instituicao', 'alunos', 'outros'];

            tdc.forEach(function(item, i, list) {
                if(self.type == item) {
                    forms.$refs[item].model = {
                        cep: ''
                    }
                }
            })

        }

    }

}

</script>