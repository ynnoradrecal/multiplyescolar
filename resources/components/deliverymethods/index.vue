<template lang="html" src="../../views/entrega/index.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import List from "./list.vue"
import Forms from "./form.vue"

export default {
	
	components: { List, Forms },

	props: ["url", "data", 'host'],

	data() {
		return {
			button: [],
		}
	},

	mounted() {
		// console.log(this.data)
	},

	methods: {

		update() {
			this.$root.$refs.delivery.$refs.form.update({
				host: this.host
			})
		},

	}

}
</script> 