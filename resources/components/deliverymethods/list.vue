<template lang="html" src="../../views/entrega/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue"

export default {

	components: { PulseLoader },

	data() {
		return {
	
			root: "",
			form: "",

			fields: "id,nome,slug",

			table: "#list",

			bool: {
				load: true
			},
			
			dataTable: {},
			data: [],

		}
	},

	mounted() {

		this.root = this.$root.$refs.delivery;
		this.form = this.root.$refs.form;

		this.ListDataTable();
		this.GetRowsDataTable();

	},

	methods: {

		ListDataTable() {

			
			var self = this;

			this.dataTable = jQuery(this.table).DataTable({
				searchDelay: 10000,
				language: "",
				lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
				drawCallback: function() {
					$(".select").off("click").on("click", function( event, index ) {
						event.preventDefault()
						
						var id = $(this).attr("ref")

						if( id == 5 ) {
							self.form.type = "correios";
						}

						if( id == 6 ) {
							self.form.type = "frete_gratis";
						}

						if( id == 9 ) {
							self.form.type = "transportadora" ;
						}

						if( id == 10 ) {
							self.form.type = "retirar_no_local" ;
						}

						
						self.form.CheckedICheck();
						
					})
				}
			})

		},

		GetRowsDataTable() {

			this.bool.load = true

			var src = this.$resource( this.root.host +"/modulos"  )

			src.query().then(function( res ) {
				
				var data = res.data.modulos,
					list = [],
					model = res.data.data // dados dos modulos	

				console.log( model )

				this.form.correios         = model.correios[0]
				this.form.frete_gratis     = model.frete_gratis[0]
				this.form.retirar_no_local = model.retirar_no_local[0]
				this.form.transportadora   = model.transportadora[0]

				this.form.correios         = Object.assign({}, this.form.correios, {"nome":data[0]["nome"]})
				this.form.frete_gratis     = Object.assign({}, this.form.frete_gratis, {"nome":data[1]["nome"]})
				this.form.transportadora   = Object.assign({}, this.form.transportadora, {"nome":data[2]["nome"]})
				this.form.retirar_no_local = Object.assign({}, this.form.retirar_no_local, {"nome":data[3]["nome"]})


				for( var i = 0; i<data.length; i++ ) {  

					this.fields.split(",").forEach(function(item, x) {
						list[i] = Object.assign({}, list[i], {[item]:data[i][item]})
					}) 

				}

				this.data = list
				this.AddRowsDataTable(list)
				this.bool.load = false

			})

		},

		AddRowsDataTable( data ) {

			var self = this

			if( data.length == 0 )
				data = this.data
			
			data.forEach(function(item, i) {

				self.dataTable.row.add(
					[
						["<label><a class=\"select\" ref=\"",
							item.id,
							"\" href=\"#\">",
							item.nome,
						"</a></label>"].join("")
					]
				).draw(false)

			})

		}
	}
}
</script> 