<template lang="html" src="../../views/produtos/politica.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/produtos.scss"></style> -->
<script>

    import PulseLoader from "../plugins/vue-spinner.vue"

    export default {

        components: { PulseLoader },

        props: ["error"],

        data() {
            return {

                // components
                root: "",

                bool: {
                    list: true
                },

                // model
                list: [],

                model: []

            }
        },

        mounted() {

            this.root = this.$root.$refs.product

            var src = this.$resource( this.root.host +"/init" )
            src.get({"methods":"getPolicy"}).then(function( res ) {
                this.list = res.data.data
                this.bool.list = false
            })

        },

        methods: {

            AddPolicysModel( policys ) {
                
                var myself = this

                this.model = []

                policys.forEach(function(item, i) { 
                    myself.model.push( item.politica_id )
                })

            },

            CleanPolicy() {

                this.model = []

            }

        }

    }
</script>