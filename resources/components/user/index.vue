<template lang="html" src="../../views/usuarios/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

    import List from "./list.vue"
    import UsForm from "./form.vue"

    export default {

        components: { List, UsForm }, 

        props: ['url', 'host'],

        data() {
            return {

                title: "Usuários",

                form: "",
                avatar: "",

                button: { "save":true, "put":false, "add":false, "destroy":false }

            } 
        },

        mounted() {
            this.form = this.$root.$refs.user.$refs.form 
            this.avatar = this.form.$refs.avatar
        },

        methods: {

            add() {

                this.enableButton([0])
                this.form.clearModel()
                this.avatar.Bool(["anexar"])

            },

            save() { this.form.save() },

            put() { this.form.put() },

            destroy() { this.form.destroy() },

            enableButton( arr ) {   
                var self = this
                Object.keys(this.button).forEach(function(item, i) {
                    if( arr.indexOf(i) != -1 ) {
                        self.button[item] = true
                    }else{
                        self.button[item] = false
                    }
                })
            }

        },

    }

</script>