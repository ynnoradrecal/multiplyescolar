<template lang="html" src="../../views/developer/list.html"></template>
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

		this.root = this.$root.$refs.developer
		this.form = this.root.$refs.form

		this.ListDataTable()
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
						event.preventDefault()

						var id = $(this).attr("ref"),
							modulos = ["google", "facebook"],
							ids   = ["8", "7"]

							self.form.type = modulos[ids.indexOf(id)]
							
							self.form.ICheck();
							self.form.CheckedICheck();

						//self.form.CheckedICheck()
						
					})
				}
			})                

		},

		GetRowsDataTable() {

			this.bool.load = true

			var src = this.$resource( this.root.host +"/modulos"  ),
				facebook = this.form.$refs.facebook,
				google   = this.form.$refs.google

			src.query().then(function( res ) {
				
				var data = res.data.modulos,
					list = [],
					model = res.data.data // dados dos modulos

				if(model.facebook[0].file.length != 0) {
					model.facebook[0].file = JSON.parse(model.facebook[0].file);
					facebook.button_image('delete');
				}

				google.store   = model.google[0]
				facebook.store = model.facebook[0]

				facebook.store = Object.assign({}, facebook.store, {"nome":data[0]["nome"]})
				google.store   = Object.assign({}, google.store, {"nome":data[1]["nome"]})

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