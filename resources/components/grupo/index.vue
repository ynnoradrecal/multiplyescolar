<template lang="html">
    <div class="" id="grupos">

        <div class="page-title">
            <div class="title_left">
                <h3>{{ title }}</h3>
            </div>
            <div class="title_right text-right">
                <div class="btn-order-view">

                    <button v-show="button.destroy" @click="destroy" type="button" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Deletar
				    </button>

                    <button v-show="button.add" @click="add" type="button" class="btn btn-primary">
                        <i class="fa fa-pencil"></i> Adicionar novo
                    </button>

                    <button v-show="button.put" @click="put" type="button" class="btn btn-success">
                        <i class="fa fa-refresh"></i>Atualizar
                    </button>

                    <button v-show="button.save" @click="save" type="button" class="btn btn-success">
                        <i class="fa fa-save"></i> Salvar
                    </button>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-5 col-dm-5 col-xs-12">
                <list ref="list"></list>
            </div>
            <gp-form ref="form"></gp-form>
        </div> 
    </div>
</template>
<script>

    import List from "./list.vue"
    import GpForm from "./form.vue"

    export default {

        components: { List, GpForm }, 

        props: ["data"],

        data() {
            return {
                host: "/admin/administrativo",
                title: "Usuários",
                form: "",
                button: { "save":true, "put":false, "add":false, "destroy":false }
            } 
        },

        mounted() {
            this.form = this.$root.$refs.grupo.$refs.form
        },

        methods: {

            add() {

                var store = this.form.store

                this.enableButton([0])
                this.form.resetStore()
                this.form.$refs.tree.resetICheck( Object.keys( store.tree ) )

            },

            save() { this.form.save() },

            put() { this.form.put() },

            destroy() { this.form.destroy() },

            enableButton( arr ) {   
                var self = this
                Object.keys(this.button).forEach(function(item, i) {
                    if( arr.indexOf(i) != -1 ) {
                        self.button[item] = true
                    }else{
                        self.button[item] = false
                    }
                })
            }

        },

    }

</script>