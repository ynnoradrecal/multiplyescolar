<script>

	import PulseLoader from "../plugins/vue-spinner.vue"

	export default {

		components: { PulseLoader },

		data() {
			return {

				table: "#list",

				valueDateRange: "Filtro",

				dataTable: {},
				loader: true,
				data: [],

			}
		},  
		
		mounted() {

			this.listDataTable()
			this.dateRangePicker()

		},

		methods: {

			dateRangePicker() {

				var start, end, self

				start = moment().subtract(29, 'days')
				end = moment()
				self = this

				$('#reportrange').daterangepicker({
					"locale": {
						"applyLabel": "Buscar",
						"cancelLabel": "x",
					}
				}, function(start, end) {
					self.valueDateRange = start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY');
					self.filterForDate()
				});
			},

			listDataTable() {

				var self, root

				self = this
				root = this.$root.$refs.visitas // component

				this.dataTable = $(this.table).DataTable({
					searchDelay: 10000,
					language: "",
					lengthMenu: [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
					initComplete: this.dataTableComplete(),
					drawCallback: function() {}
				})

				this.rowsDataTable( JSON.parse( root.data ) )
				this.data = JSON.parse( root.data )

			},

			rowsDataTable( data ) {

				var self = this

				if( data.length == 0 )
					data = this.data

				data.forEach(function(item, i) {

					self.dataTable.row.add(
						[
							item.id, 
							item.ip, 
							item.sistema, 
							item.navegador, 
							item.pagina, 
							self.dateFormatBr(item.created_at, "dateAndHour")
						]
					).draw(false)

				})

			},

			filterForDate() {

				var dateStart, dateEnd, frags, self, data = [], list_date

				self = this

				frags     = this.valueDateRange.split("-")
				dateStart = this.getDatePutMonths(frags[0].replace(",", "").trim().split(" "), 1)
				dateEnd   = this.getDatePutMonths(frags[1].replace(",", "").trim().split(" "), 1)
				
				this.dataTable.clear().draw()

				this.data.forEach(function(item, i) {

					list_date = parseInt(self.data[i].created_at.split(" ").shift().split("-").join(""))
					
					if( list_date >= dateStart && list_date <= dateEnd ) {
						data.push(self.data[i])
					}

				}) 

				this.rowsDataTable( data )

			},

			getDatePutMonths( date, i ) {
				
				var months, list, month

				months = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]
				list   = [10, 11, 12]
				month  = months.indexOf(date[i]) + 1

				if( month < 10 ) {
					date[i] = (0 +""+ month).toString()
				}

				return parseInt(date.reverse().join(""))

			},

			dateFormatBr( data, tipo_retorno ) {

				var frags, date, hour

				frags = data.split(" ")
				date  = frags[0]
				hour  = frags[1]

				if( tipo_retorno == "dateAndHour" ) {
					return date.split("-").reverse().join("/") +" "+ hour
				}

				if( tipo_retorno == "onlyDate" ) {
					return date.split("-").reverse().join("/")
				}

			},

			dataTableComplete() {
				this.loader = false
			},

		}
	}

</script> 
<template lang="html">
	<div class="x_panel">
		<div class="x_title">
			<h2><i class="fa fa-cube"></i> Visitantes</h2>
			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
				<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
				<span>{{ valueDateRange }}</span> <b class="caret"></b>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="col-xs-12">
				<div v-show="loader">
					<pulse-loader class="loader text-center"></pulse-loader>
				</div>
				<div v-show="!loader">
					<table id="list" class="table table-striped table-bordered" width="100%">
						<thead>
							<tr class="">
								<th>ID</th>
								<th>IP</th>
								<th>Sistema</th>
								<th>Navegador</th>
								<th>Rota</th>
								<th>Data</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>  
		</div>
	</div>
</template>