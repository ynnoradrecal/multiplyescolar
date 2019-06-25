<template lang="html" src="../../views/produtos/entrega.html"></template>
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
                    list: true,
                    instituicao: false,
                    clone: false
                },

                // model
                list: [],

                model: ["5"],

                instituicoes: [],

                instituicao_id: 0,

            }
        },

        mounted() {
            
            this.root = this.$root.$refs.product

            var self = this, $delivery = $('.delivery');

            $( ".target" ).change(function() {

                var status = 'disable';

                if($(this).val() == 0) {

                    status = 'enable';
                    
                }

                self.model = [];
                $delivery.find('li input[type="checkbox"]').iCheck('uncheck');

                self.instituicao_id = $(this).val();

                for( var i = 0; i < 4; i++ ) {
                    $delivery.find('li:eq('+i+') input[type="checkbox"]').iCheck(status);
                }

            });

            $delivery.find('li input[type="checkbox"]').on('ifClicked', function(event){

                var $type = $(this).val().toString();
                
                // if( $type === '12' ) {

                //     self.__check_school( $delivery, $(this) );

                //     return false;

                // }
                
                self.__add_value_model( $type );
                

            })

            this.__get_instituicoes();

        },

        methods: {

            __add_value_model( $type ) {

                var self = this;

                if( this.model.indexOf($type) == -1 ) {
                    this.model.push($type.toString());
                }else{
                    this.model.forEach(function(item, i) {

                        if(item == $type) {
                            self.model.splice(i, 1);
                        }

                    })
                }

            },

            AddDeliveryModel( delivery, id_instituicao ) {

                var self = this, $delivery = $('.delivery');

                if( id_instituicao == 0 ) {

                    this.model = [];

                    for( var i in delivery ) {
                        self.model.push( delivery[i].modulo_id.toString() );
                    }   

                    for( var i = 0; i < $delivery.find('li').size(); i++ ) {

                        if( self.model.indexOf( $delivery.find('li:eq('+ i +') input[type="checkbox"]').attr('value') ) != -1 ) {
                            $delivery.find('li:eq('+ i +') input[type="checkbox"]').iCheck('check');
                        }
                        
                    }

                }else{

                    for( var i = 0; i < 4; i++ ) {
                        $delivery.find('li:eq('+i+') input[type="checkbox"]').iCheck('disable');
                    }

                    this.bool.instituicao = true;
                    this.instituicao_id = id_instituicao;

                }
                
                    

            },

            __get_instituicoes() {

                var src = this.$resource( this.root.host +"/init" );
                src.query({"methods":'__get_instituicoes'}).then(function(response) {
                    this.instituicoes = response.data;
                })

            },

            // __check_school( $el, $this ) {

            //     var status = 'disable';

            //     if($this.attr('class') == 'enable') {

            //         // aqui executa a maior façanha de todos os tempos
            //         var clone = $('.clone').find('li').clone();
            //         var index = $el.find('li').size() - 2;

            //         $this.parents('li').remove();
            //         $el.append(clone);
            //         // fim da incrivel facinha que poderia ser bem mais simples, mas nao!

            //         status = 'enable';

            //         this.bool.instituicao = false;
            //         this.instituicao_id = 0;
                    
            //     }else{

            //         $this.attr('class', 'enable');

            //         this.bool.instituicao = true;
            //         this.model = [];

            //     }

            //     for( var i = 0; i < 4; i++ ) {
            //         $el.find('li:eq('+i+') input[type="checkbox"]').iCheck(status);
            //     }        

            // },

        }

    }
</script>