<template lang="html" src="../../../views/contas/forms/outros.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>

import AwesomeMask from 'awesome-mask';

export default {

	directives: {
        'mask': AwesomeMask
    },
	
    data() {
        return {

            title: 'Clientes',

            status: false,

            error: {},
            model: {}   
        }
    }
}
</script>