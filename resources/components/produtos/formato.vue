<template lang="html" src="../../views/produtos/formato.html"></template>
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

                model: [5]

            }
        },

        mounted() {

  
            var self = this, $formato = $('.formato');

            $formato.find('li input[type="checkbox"]').on('ifClicked', function(event){

            	var $type = $(this).val().toString();

                if( self.model.indexOf($type) == -1 ) {
                	self.model.push($type.toString());
                }else{
                	self.model.forEach(function(item, i) {
                		if(item == $type) {
                			self.model.splice(i, 1);
                		}
                	})
                }

            })

        },

        methods: {
           
        	AddDeliveryModel( delivery ) {
                
                var self = this, $formato = $('.formato');
                
                this.model = [];

                for( var i in formato ) {
                	self.model.push( formato[i].modulo_id.toString() );
                }	

                for( var i = 0; i < $formato.find('li').size(); i++ ) {

                	if( self.model.indexOf( $formato.find('li:eq('+ i +') input[type="checkbox"]').attr('value') ) != -1 ) {
                		$formato.find('li:eq('+ i +') input[type="checkbox"]').iCheck('check');
                	}
                	
                }

            },

        }

    }
</script>