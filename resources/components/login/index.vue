<template lang="html" src="../../views/login/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

var PulseLoader = require('vue-spinner/dist/vue-spinner.min').PulseLoader;

export default {

    components: {
        PulseLoader
    },

    props: ['url', 'host'],

    //model
    data(){
        return {

            spinner: {
                color: "#009cde",
                load: false,
            },

            error: {},

            model: {
                login: '',
                senha: ''
            }

        }
    },

    // construct
    mounted() {

    },

    //controller
    methods: {

        login() {
            
            var src = this.$resource(this.host +'/init')

            this.error = {};
            this.spinner.load = true;

            src.save({'methods':'__in', 'data':this.model}).then(function(res) {

                var res = res.data;

                if( res.status == 1 ) {
                    location.href = res.redirect;
                }else{   
                    this.__alert( res.data.alert );
                }

            }, function(res) {

                this.__error( res.data );
                this.spinner.load = false;

            })

        },

        __error( data ) {

            var self = this, email= '', senha= '';
            
            Object.keys(data).forEach(function(item, i, field) {

                self.error = Object.assign({}, self.error, {
                    [item.replace('data.', '')]: [data[item][0].replace('data.', '')]
                })

            })

        },

        __alert( data ) {

            if( typeof data != 'undefined' ) {
                this.$swal(data.title, data.text, data.type)
            }

        },

    }

}
</script>