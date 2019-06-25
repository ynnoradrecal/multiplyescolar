<template lang="html" src="../../views/politica/form.html"></template>
<style lang="sass" src="../../assets/admin/sass/components/load.scss"></style>
<script>

	import PulseLoader from "../plugins/vue-spinner.vue"
	//import Campos from "./campos.vue"
	import Personalizados from "./personalizados.vue"

	export default {

		components: { PulseLoader, Personalizados },
		
		data() {
			return {
				
				title: "Nova Política",

				error: [],

				// components
                root: "",
                list: "",
				perso: "",

				// booleano
				bool: {
                    load: false,
					grids: false // Formulularios de Personalização
                },

				// value form
				model: {
					nome: "",
					tipo: "",
					quantidade: "",
					campos: [],
					descricao: "", // opcional
					list: []
				}

			}
		},

		mounted() {

			this.root = this.$root.$refs.policy
			this.list = this.root.$refs.list
			this.perso = this.root.$refs.form.$refs.perso

		},

		methods: {

			Store() {

				this.bool.load = true
				this.QueryResource( this.$resource( this.root.host +"/store" ), "insert" )

			},

			Put() {
					
				var self = this;

				this.bool.load = true;
				this.model.list = [];

				this.perso.model.forEach(function(item, i, list) {

					if( !Array.isArray(list[i]) ) {
						self.model.list.push(list[i]);
					}

				});
				
				this.QueryResource( this.$resource( this.root.host +"/put" ), "update" );

			},

			Destroy( setting ) {
				
				var myself = this;

				setting.text += this.model.nome;

				this.$swal( setting ).then(function() {

					myself.bool.load = true					
					myself.QueryResource( myself.$resource( myself.root.host +"/destroy" ), "delete" )

				})

			},

			QueryResource( src, type ) {

				var types = ["delete", "update"]; // configurações extras dependendo do type

				src.save( this.model ).then(function( res ) {

					this.Alert( res.data.alert )
					this.Error([])
					this.bool.load = false

					this.list.RefreshDataTable()

					if(types.indexOf(type) == -1) {
						this.CleanModel()
					}

					if( type == "delete" ) {
						this.CleanModel();
						this.perso.model = [];
						this.perso.quantidade = [];
					}

					if( type == 'update' ) {

						var pers = this.perso, 
							data = res.data.data;

						pers.model.forEach(function(item, i, pers) {
							item.path = data.path;
							for( var j in item.images ) {
								pers[i].images[j].image = item.images[j].image.replace('/uploads/tmp/', '');
							}
						});

					}
					
				}, function( res ) {

					this.Error( res.data )

					this.bool.load = false

				})

			},

			Alert( data ) {
				this.$swal(data.title, data.text, data.type)
			},

			Error( data ) {

                if(data.length == 0) {
                    this.error = []
                }else{

					this.error = []

                    for( var item in data ) {
                        this.error[ item ] = [data[item][0]]
                    }

                }

                this.bool.load = false

            },

			CleanModel() {

                for( var item in this.model ) {
                    this.model[item] = ""
                }

				this.model.campos = []
				this.model.list = []

				$("input[type='checkbox']").iCheck('uncheck')

            },

		}

	}

</script>