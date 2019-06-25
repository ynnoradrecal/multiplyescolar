<template lang="html" src="../../views/dash/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>
	
	// import { Bar } from '../../vue-chartjs/dist/vue-chartjs.js';

	export default {

		props: ['host', 'url'],

		data() {
			return {

				sale: 0,
				clients: 0,
				tt_orders: 0,

				orders: [],

			}
		},

		mounted() {

			this.__get_sales();
			this.__get_client();
			this.__get_orders();

		},

		methods: {

			__get_orders() {

				var src = this.$resource( this.host )

                src.get({"methods":"__get_orders"}).then(function( res ) {

                    this.tt_orders = res.data.tt;

                    this.orders = res.data.orders.reverse();
                    console.log(this.orders);

                })

			},

			__get_client() {

				var src = this.$resource( this.host )

                src.get({"methods":"__get_client"}).then(function( res ) {
                    this.clients = res.data;
                })

			},

			__get_sales() {

				var src = this.$resource( this.host )

                src.get({"methods":"__get_sales"}).then(function( res ) {
                    this.sale = this.__number_to_real(res.data);
                })


			},

			__number_to_real( numero ) {

	            var numero = parseInt(numero).toFixed(2).split('.');

	            numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');

	            return numero.join(',');

	        },

	        __status_pgs( n ) {

	            var status = ['', 'Aguardando pagamento', 'Em análise', 'Paga', 'Disponível', 'Em disputa', 'Devolvida', 'Cancelada'];

	            return status[n];

	        },

		}

	}

</script>