<template lang="html" src="../../views/order/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

export default {

    props: ['title'],

    data() {
        return {

            url: "",

            // booleano
            bool: {
                load: true,
            },

            // components
            root: "",

            table: "#list",
            dataTable: {}, // API

            list: {
                num_pedido: Math.random() * 2,
                cod_transacao: "2BFE0936-DE1B-4E80-84BE-D6AFDA17AF20",
                data: "19/04/2017",
                cliente: "João da Silva",
                entrega_para: "João da Silva",
                valor_cobrado: "R$ 1.200,00",
                status: "Completo"
            },

            data: [],

            // campos da base de dados
            fields: 'id,num_pedido,code_transacao,created_at,name,valor_pedido,status',

        }
    },

    mounted() {

        // jQuery("#list").DataTable({
        //     "language": this.$root.$refs.order.datatable.lang,
        // }); 

        this.root = this.$root.$refs.order;
        this.url  = this.root.url;
        
        this.ListDataTable() // jquery Datatable...
        this.GetRowsDataTable()

    },

    methods: {

        ListDataTable() {

            var self = this

            this.dataTable = $(this.table).DataTable({
                searchDelay: 10000,
                language: "",
                lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                //initComplete: this.DataTableComplete(),
                drawCallback: function() {
                    $(".select").off("click").on("click", function( event ) {

                        var $href = $(this).attr('href');

                        if($href == '#archive') {
                            self.root.__archive();
                            return false;
                        }else{
                            self.root.layout = 'order_view';
                            self.root.id = $(this).attr('ref');
                        }

                        event.preventDefault()
                    })
                }
            })                

        },

        GetRowsDataTable() {

            var src = this.$resource( this.root.host +"/show"  );
            var status = this.root.status;

            this.bool.load = true

            src.query({status: status}).then(function( res ) {
                
                var data = res.data,
                    list = [];

                for( var i = 0; i<data.length; i++ ) {  
                    this.fields.split(",").forEach(function(item, x) {
                        list[i] = Object.assign({}, list[i], {[item]:data[i][item]})
                    }) 
                }

                this.data = list;

                this.AddRowsDataTable(list);

                this.bool.load = false;


            })

        },

        AddRowsDataTable( data ) {

            var self = this

            if( data.length == 0 )
                data = this.data
        

            data.forEach(function(item, i) {

                self.dataTable.row.add(
                    [
                        item.num_pedido, item.code_transacao, 
                        self.root.__date_ptbr(item.created_at), 
                        item.name, item.name, 
                        'R$ '+ self.root.__format_real(item.valor_pedido), 
                        self.root.__status_pgs(item.status), 
                        [
                            '<td>&nbsp;&nbsp;&nbsp;&nbsp;',
                                '<a href="#" ref="'+ item.id +'" title="Visualizar" class="btn btn-primary btn-xs select">',
                                    '<i class="fa fa-sign-in"></i>',
                                '</a>',
                            '</td>'
                        ].join(''),
                    ]
                ).draw(false)

            })

        }, 

    }

}

</script>
<!-- #STYLE -->
<style>
    .dataTables_filter { text-align: right; }
</style>