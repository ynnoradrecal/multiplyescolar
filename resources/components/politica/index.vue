<template lang="html" src="../../views/politica/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

	import List from './list.vue'
	import PlForm from './form.vue'

	export default {

		components: { List, PlForm },

		props: ['url', 'host'],

		data() {
			return {

				title: "Politicas de Compras",
                button: { "save":true, "put":false, "add":false, "destroy":false },

				form: "",
				list: "",
				perso: ""

			}
		},

		mounted() {

			this.form = this.$root.$refs.policy.$refs.form
			this.list = this.$root.$refs.policy.$refs.list

			this.pers = this.form.$refs.perso

		},

		methods: {

			add() {

                this.EnableButton([0])
				this.form.CleanModel()

				this.form.bool.grids = false

				this.pers.model = [];
				this.pers.quantidade = [];
				
				// this.pers.error = []

            },

            save() { this.form.Store() },

            put() { this.form.Put() },

            destroy() { 

				this.form.Destroy({
					title: 'Deseja realmente deletar?', 
					text: "Política ",
					type: 'warning',
					showCancelButton: true, 
					confirmButtonColor: '#169F85', 
					cancelButtonColor: '#d9534f', 
					confirmButtonText: 'Sim, Deletar!'
				}) 

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