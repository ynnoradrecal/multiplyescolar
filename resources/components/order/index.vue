<template lang="html" src="../../views/order/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import List from './list.vue'
import OrderView from './order-view.vue'
import AbandCart from './aband-cart.vue'
import NavButton from './nav-button.vue'

import MsBox from '../msbox.vue'

export default {

    components: { List, OrderView, AbandCart, NavButton, MsBox },

    props: ['url', 'host'],

    data() {
        return {

            layout: '',
            status: 0,
            title: 'Pedidos Em Aberto',

            id: '',

            datatable: {
                lang: {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Resultados<br> _MENU_",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Prôximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            },
            
        }
    },

    mounted() {
        
    },

    methods: {

        __page_pedidos( type ) {
        
            var refs = this.$root.$refs.order.$refs;

            this.layout = '';

            if( type == 'em_aberto' ) {
                this.status = 0;
                this.title = 'Pedidos Em Aberto';
            }

            if( type == 'concluido' ) {

                this.status = 1;
                this.title = 'Pedidos Concluídos';

            }

            refs.list.dataTable.clear().draw();
            refs.list.GetRowsDataTable();

        },

        __status_do_pedido( status ) {

            var self = this;
            var title = 'Deseja finalizar esse<br> PEDIDO?';

            if( status == 0 ) {
                var title = 'Deseja estornar esse<br> PEDIDO?';
            }

            this.$swal({
                title: title, 
                // text: 'Essa pedido sera determinado como concluido.',
                type: 'warning',
                showCancelButton: true, 
                confirmButtonColor: '#169F85', 
                cancelButtonColor: '#d9534f', 
                confirmButtonText: 'Concluir!'
            }).then(function() {

                var order_view = self.$root.$refs.order.$refs.orderview;

                var src = self.$resource( self.host +"/init" );
                var id  = order_view.data.id;

                src.save({'methods':'__pedido_concluido', 'post':{'status':status, 'id':id}})
                    .then(function( response ) {
                        self.$swal('Sucesso!', 'Status Pedido alterado com sucesso.', 'success');
                })

            });

        },

        __date_ptbr( data ) {
            return data.substr(0, 10).split('-').reverse().join('/');
        },

        __format_real( data ) {

            return data.toLocaleString('pt-BR');

        },

        __status_pgs( n ) {

            var status = ['', 'Aguardando pagamento', 'Em análise', 'Paga', 'Disponível', 'Em disputa', 'Devolvida', 'Cancelada'];

            return status[n];

        },

    },

}

</script>