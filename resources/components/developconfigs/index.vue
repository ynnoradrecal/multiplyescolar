<template lang="html" src="../../views/developer/index.html"></template>
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

			form: "",

		}
	},

	mounted() {
		this.form = this.$root.$refs.developer.$refs.form
	},

	methods: {

		update() {
			
			this.form.update( {"host":this.host} );
			
		},

	}

}
</script> 