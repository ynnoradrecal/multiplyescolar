<template lang="html">
    <div class="title_right text-right">
        <div class="btn-order-view">
            <a :href="url +'/admin/sales/order'" class="btn btn-primary"><i class="fa fa-sign-out"></i> Voltar</a>
            <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i> Deletar</a> 
            <a href="#" id="compose" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar Email</a> 
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            url: ""
        }
    },
    mounted() {
        this.url = this.$root.$refs.order.url;
    }
}
</script>