<template lang="html" src="../../../views/developer/forms/google.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import PulseLoader from "../../plugins/vue-spinner.vue"

export default {

	components: { PulseLoader },

	props: ["type"],

	data() {
		return {

			loader: 'off',

			error: [],
			store: {
				status: 0,
				nome: 'Google'
			}

		}
	},


}

</script>