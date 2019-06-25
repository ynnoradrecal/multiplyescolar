<!-- #TEMPLATE -->
<template 
    lang="html" 
    src="../../../App/Modules/Admin/Views/Sections/Order/aband-cart.html">
</template>
<!-- #SCRIPT -->
<script>
    export default {
        data() {
            return {
                url: "",
                cart: {
                    cliente: "João da Silva",
                    email: "joao@gmail.com",
                    fone: "11 4575 5664",
                    cel: "11 9 6565 4564",
                    produto: "Album do Guilherme",
                    data: "26/04/2019",
                    valor: "R$4.500,50"
                }
            }
        },
        mounted() {
            this.url = this.$root.$refs.order.url;
            jQuery("#list").DataTable({
                "language": this.$root.$refs.order.datatable.lang,
            }); 
        }
    }
</script>