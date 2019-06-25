<template lang="html" src="../../views/order/orderview.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<style lang="sass">
    .story{
        position: relative;
        .loader {
            position: absolute;
            padding: 0;
            top: 10px; right: 22px;
        }
    }
</style>
<script>

var PulseLoader = require('vue-spinner/dist/vue-spinner.min').PulseLoader;

export default {

    components: { PulseLoader },

    data() {

        return {

            spinner: {
                color: "#009cde",
            },

            bool: {
                load: false
            },

            url: "",

            data: {},

            root: '',

            model: {},

            opcoes: [],
            fotos: [],

            sub_total: 0,

            desconto: 0,

            total: 0,
        }

    },

    mounted() {
        
        this.url = this.$root.$refs.order.url;
        this.root = this.$root.$refs.order;

        this.__get_order_for_id();
        this.__get_notice_for_id();

    },

    computed: {

        __status_pgs() {

            var status = [
                '', 
                'Aguardando pagamento', 
                'Em análise', 
                'Paga', 
                'Disponível', 
                'Em disputa', 
                'Devolvida', 
                'Cancelada'
            ];

            return status[this.data.status];
        },

    },

    methods: {

        __total(sub_total, desconto, frete) {


            var total = (parseInt(sub_total) + parseInt(frete)) - parseInt(desconto);

            return this.__number_to_real(total);

        },

        __sub_total( _fotos, _opcoes ) {

            var st = 0; // sub total

            var ttf = _fotos.length, tto = _opcoes.length;

            for( var f = 0; f < ttf; f++  ) {
                st = (st + parseInt(_fotos[f].preco));
            }

            if( tto != 0 ) {

                for( var i = 0; i < tto; i++ ) {
                    st = (st + parseInt(_opcoes[i].preco));
                }

            }

            return st;

        },

        __date_ptbr( data ) {

            if( data != undefined ) {

                var date = data.split(' ').reverse().pop();

                return date.split('-').reverse().join('/');

            }

        },

        __price_ptbr() {

            this.data.itens.desc.forEach(function(item, i, list) {
                list[i].preco = item.preco.toLocaleString();
            })
            
        },

        __get_order_for_id() {

            var id = this.root.id,
                self = this;

            var src = this.$resource( this.root.host +"/init" )
            src.save({'methods':'__get_order_for_id', 'id':id}).then(function( response ) {

                this.data = response.data[0];

                this.fotos  = this.data.itens.fotos  || [];
                this.opcoes = this.data.itens.opcoes || [];

                this.desconto = this.__number_to_real(this.data.desconto);

                var sub_total = this.__sub_total( this.fotos, this.opcoes );

                this.sub_total = this.__number_to_real(sub_total);

                this.total = this.__total(sub_total, this.data.desconto, this.data.valor_frete);

                this.model.pagamento = this.root.__status_pgs(this.data.status);

            })

        },

        __number_to_real(numero) {

            var numero = parseInt(numero).toFixed(2).split('.');

            numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');

            return numero.join(',');

        },

        __save_notice() {

            var cdate = new Date(),
                date = cdate.getFullYear() +'-'+ (cdate.getMonth() + 1) +'-'+ cdate.getDate(),
                src = this.$resource( this.root.host +"/init" );

            this.model.id_pedido = this.root.id;

            if( (this.model.entrega && this.model.comentario) == undefined ) {
                console.log('Selecione uma opção de status para entrega!')
                return false;
            }

            this.bool.load = true;

            src.save({'methods':'__post_notice', 'post':this.model}).then(function( response ) {

                if( response.data.status == 'success' ) {

                    this.data.notice.push({
                        'entrega': this.model.entrega,
                        'pagamento': this.model.pagamento,
                        'comentario': this.model.comentario,
                        'created_at': date +' _' 
                    });

                    this.model = {
                        'pagamento': this.model.pagamento,
                    };

                    this.bool.load = false;

                }

            })

        },

        __get_notice_for_id() {

            var self = this, data;

            var src = self.$resource( self.root.host +"/init" )
            src.save({'methods':'__get_notice_for_id', 'id':self.root.id}).then(function( response ) {

                self.data = Object.assign({}, self.data, {'notice':response.data});


            })

        }

    }

}

</script>