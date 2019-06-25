<template lang="html">
    <div class="title_right text-right">
        <div class="btn-order-view">
            
            <a v-show="btn.back" :href="url +'/admin/sales/order'" class="btn btn-primary">
                <i class="fa fa-sign-out"></i> Voltar
            </a>
            
            <a v-show="btn.delete" href="#" class="btn btn-danger"><i class="fa fa-trash"></i> Deletar</a> 
            
            <a v-show="btn.send" href="#" id="compose" class="btn btn-primary">
                <i class="fa fa-envelope-o"></i> Enviar Email
            </a> 

            <button v-show="btn.save" type="button" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>

        </div>
    </div>
</template>
<script>
export default {

    data() {
        return {
            url: "",
            btn: { back: false, delete: false, send: false, save: false }
        }
    },
    
    mounted() {
        
    }

}
</script>