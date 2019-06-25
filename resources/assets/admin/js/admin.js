
import Vue from "vue/dist/vue"
import VueResource from "vue-resource/dist/vue-resource"
import VueSweetAlert from 'vue-sweetalert/build/vue-sweetalert'
import VueMask from "v-mask"


// Components
import Login from '../../../components/login/index.vue'; // Login
import Dash from '../../../components/dash/index.vue'; // Dash
import Events from '../../../components/events/index.vue'; // Events
import Accounts from '../../../components/accounts/index.vue'; // Accounts
import Paymentmethods from '../../../components/paymentmethods/index.vue'; // PaymentMethods
import Configuracaoloja from '../../../components/configuracaoloja/index.vue'; // Configuraçao Loja
import Deliverymethods from '../../../components/deliverymethods/index.vue'; // DeliveryMethods
import Developconfigs from '../../../components/developconfigs/index.vue'; // DevelopConfigs
import Visitas from '../../../components/visitas/index.vue'; // Visiras
import Politica from '../../../components/politica/index.vue'; // Policy
import Order from '../../../components/order/index.vue'; // Order
import Grupo from '../../../components/grupo/index.vue'; // Grupo
import User from '../../../components/user/index.vue'; // User
import Produtos from '../../../components/produtos/index.vue'; // Produtos
import Fotos from '../../../components/fotos/index.vue'; // Fotos


// Vue Resource 
Vue.use(VueResource)

// Vue sweet Alert
Vue.use(VueSweetAlert)

// Vue mask
Vue.use(VueMask);

Vue.use(require('vue-moment'))

Vue.http.options.root = "https://jsonplaceholder.typicode.com"
Vue.http.headers.common['Authorization'] = "YXBpOnBhc3N3b3Jk"
Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken

new Vue({

	el: "#app",

	components: {
		Login,
		Dash,
		Events, 
		Accounts, 
		Politica, 
		Order,
		Paymentmethods,
		Configuracaoloja,
		Deliverymethods,
		Developconfigs,
		Visitas,
		Grupo,
		User,
		Produtos,
		Fotos

	},

})
