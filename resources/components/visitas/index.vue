<template
    lang="html"
    src="../../../App/Modules/Admin/Views/Sections/Visitas/index.html">
</template>
<script>

    import PulseLoader from "../plugins/vue-spinner.vue"
    import List from "./list.vue"

    export default {

        components: { List, PulseLoader },

        props: ["url", "data" ],

        // model
        data() {
            return {
                
                host: "/admin/relatorio/visitas",

                error: [],
                date:{
                    inicial: '',
                    final: ''
                }

            }
        },

        // construct
        mounted() 
        {

        },

        // controller
        methods: {

            buscarPeriodo(){

            
            }

        }

    }

</script>