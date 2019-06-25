<template lang="html" src="../../views/loja/index.html"></template>
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
		
	},

	methods: {

		show() {
			this.$root.$refs.configloja.$refs.form.show({
				host: this.host
			})
		},

		update() {
			this.$root.$refs.configloja.$refs.form.update({
				host: this.host
			})
		}
	
	}

}
</script> 