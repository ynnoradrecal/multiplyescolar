<!-- item template -->
<template id="item">
    <div class="x_content">
        <li v-if="model.length" v-for="item in model">
            <label :for="item.slug">
                <input type="checkbox" :name="item.slug" :value="item.ponteiro"> 
                <span>{{ item.titulo }}</span>
            </label>
            <ul v-if="item.tree.length">
                <item ref="tree" :model="item.tree"></item>
            </ul>
        </li>
    </div>
</template>
<script>

    import Item from "./item.vue"

    export default {

        name: 'item',
        components: { Item },

        props: ["model"],

        data() {
            return {

                root: "",
                form: "",

                listName: [],
                formStoreTree: {},

                keys: "",

                list: {},
                total: 0

            }
        },

        mounted() {

            this.root = this.$root.$refs.grupo
            this.form = this.root.$refs.form

            this.iCheck()

        },

        methods: {

            AddFormStoreTree( tree, keys ) {
                
                var myself = this, list = {}, item

                item = keys.shift()
                myself.form.store.tree = Object.assign({}, myself.form.store.tree, {[tree[item-1].slug]:tree[item-1]})

                $("input[name='"+ tree[item-1].slug +"']").iCheck('check')

                if( keys.length ) {
                    myself.AddFormStoreTree( tree[item-1].tree, keys )
                }

            },

            RemoveFormStoreTree( tree, keys, ponteiro ) {

                var item = keys.shift()

                
            },

            iCheck() {

                var self = this

                $('input[name="painel"]').iCheck('check');
                $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });

                $('input').on('ifClicked', function(event){

                    var $name = $(this).attr("name"), keys = $(this).val().split(".")
                    var model = self.form.model

                    if( Object.keys( self.form.store.tree ).indexOf( $name ) == -1 ) {

                        self.AddFormStoreTree( model, keys )

                    }else{

                        self.RemoveFormStoreTree( model, keys, ponteiro )

                    }

                });

            },

            checkedInputTree( arr ) {
                arr.forEach(function(item, i) {
                    $("input[name='"+ item +"']").iCheck('check')
                }) 
            },

            resetICheck( arr ) {
                arr.forEach(function(item, i) {
                    $('input[name="'+ item +'"]').iCheck('uncheck');
                }) 
            },

            createTreeGroup( titulo, slug, ponteiro ) {  
                
                var list = [], form, keys = [], data = {}

                form = this.$root.$refs.grupo.$refs.form
                list = Object.keys(form.store.tree) // list tree

                // verificar existencia do mesmo na lista
                if( list.indexOf( slug ) != -1 ) {
                    delete form.store.tree[slug]
                }else{

                    // adicionando 
                    data = Object.assign({}, form.store.tree, { 
                        titulo: titulo, 
                        status: true,
                        ponteiro: ponteiro
                    })

                    form.store.tree[slug] = data
                    
                    // removendo bugs de repetição interno
                    Object.keys( form.store.tree ).forEach(function(item) {
                        keys = Object.keys(form.store.tree[item])
                        for( var i=0; i<keys.length; i++ ) {    
                            if( keys[i] != "titulo" && keys[i] != "status" && keys[i] != "ponteiro" ) {
                                delete form.store.tree[item][keys[i]]
                            }
                        }
                    })                    

                }

            }

        }
    }
</script>
<style lang="sass"> 
    .tree { 
        lu, li {list-style-type: none;} 
        span {
            position: relative;
            top: 3px;
        }
    } 
</style>