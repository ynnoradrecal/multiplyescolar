<template lang="html" src="../../views/eventos/list.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../plugins/vue-spinner.vue"

export default {

	components: { PulseLoader },

	props: ["list"],

	data() {
		return {

			dataTable: {},
			
			loader: true,
			
			cutout: true,

			data: [],

			table: '#list',

			// components
			root: '',

			bool: {
				load: true
			},

			dataTable: {},

		}
	},

	mounted() {

		this.root = this.$root.$refs.events
		this.form = this.root.$refs.forms

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
				drawCallback: function() {
                    $(".select").off("click").on("click", function( event ) {
						event.preventDefault()
						self.AddModel($(this).attr('ref'));
						self.root.rules_button([1, 2, 3]);
						self.form.button_image('delete');
                    })
                }
			})                

		},

		AddModel( id ) {

			var self = this;

			this.data.forEach(function(item, i, list) {
        		if( item.id == id ) {
        			self.form.model = list[i];
        		}
        	});

		},

		GetRowsDataTable() {
                
            this.bool.load = true

            var src = this.$resource( this.root.host +"/show"  )
            src.query().then(function( res ) {

            	this.data = res.data;

            	this.data.forEach(function(item, i, list) {
            		if( item.capa.length != 0 ) {
            			list[i].capa = JSON.parse(item.capa);
            		}
            	});

                this.AddRowsDataTable();
                this.bool.load = false;

            })

        },

        AddRowsDataTable() {

			var self = this

			this.data.forEach(function(item, i) {

				self.dataTable.row.add(
					[
                        ["<label><a class=\"select\" ref=\"",
                            item.id,
                            "\" href=\"#\">",
                            item.name,
                        "</a></label>"].join("")
                    ]
				).draw(false)

			})

		}

	}

}
</script>
<style> 
label { margin: 5px 0; } 
.loader{ padding: 60px 0; } 
</style>
