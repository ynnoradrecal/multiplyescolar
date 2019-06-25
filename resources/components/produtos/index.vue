<template lang="html" src="../../views/produtos/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/produtos.scss"></style> -->
<script>

    import List from './list.vue'
	import PrForm from './form.vue'

    export default {

        components: { List, PrForm },

        props: ['host', 'url'],

        data() {
            return {

                title: "Repositório",

                button: { "save":true, "put":false, "add":false, "destroy":false },

                form: "",
                regras: "",
                policy: "",

            }
        },

        mounted() {

            this.form   = this.$root.$refs.product.$refs.form
            this.regras = this.form.$refs.regras
            this.policy = this.form.$refs.policy

        },

        methods: {

            add() { this.ResetGlobal() },

            save() { this.form.Store() },

            put() { this.form.Put() },

            destroy() { 

				this.form.Destroy({
					title: 'Deseja excluir o repositório?',
					text: "Repositório sera permanentemente apagada com todos os itens dentro dele.",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#169F85',
					cancelButtonColor: '#d9534f',
					confirmButtonText: 'Sim, Deletar!'
				}) 

			},

            ResetGlobal() {

                this.form.CleanModel()
                this.regras.CleanRules()
                this.policy.CleanPolicy()

                this.EnableButton([0])

            },

            EnableButton( arr ) {   

                var myself = this

                Object.keys(this.button).forEach(function(item, i) {
                    if( arr.indexOf(i) != -1 ) {
                        myself.button[item] = true
                    }else{
                        myself.button[item] = false
                    }
                })

            }

        }

    }
</script>