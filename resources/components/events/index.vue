<template lang="html" src="../../views/eventos/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import List from "./list.vue"
import Forms from "./forms.vue"
import Btns from "../buttons.vue"

export default {

    components: { List, Forms, Btns },

    props: ["url", "data", 'host'],

    // model
    data() {
        return {
            
            button: { "save":true, "put":false, "add":false, "destroy":false },

            // components
            form: '',

        }
    },

    // construct
    mounted() 
    {
        
        this.form = this.$root.$refs.events.$refs.forms

    },

    // controller
    methods: {

        add() { this.reset_global() },

        save() { this.form.save() },

        put() { this.form.put() },

        destroy() { this.form.destroy() },
       
        rules_button( arr ) {   

            var myself = this

            Object.keys(this.button).forEach(function(item, i) {
                if( arr.indexOf(i) != -1 ) {
                    myself.button[item] = true
                }else{
                    myself.button[item] = false
                }
            })

        },

        reset_global() {

            this.rules_button([0]);

            this.form.model = [];
            this.form.error = [];
            this.form.button_image('save');

        },


    }

}
</script>