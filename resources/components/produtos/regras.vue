<template lang="html" src="../../views/produtos/regras.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/produtos.scss"></style> -->
<script>

    import AwesomeMask from 'awesome-mask';

    export default {

        directives: {
            'mask': AwesomeMask
        },

        data() {
            return {

                form: "",

                condicao: [],
                quantidade: [],
                preco: [],

                property: "condicao,quantidade,preco",

            }
        },

        mounted() {

            this.form = this.$root.$refs.product.$refs.form

        },

        methods: {

            BuildRulesObject() {

                var myself = this

                myself.form.model.regras = []

                this.condicao.forEach(function(item, i, list) {
                    
                    myself.form.model.regras.push(Object.assign({}, "", {
                        "id": list[i].id,
                        "condicao": list[i].valor,
                        "quantidade": myself.quantidade[i].valor,
                        "preco": myself.preco[i].valor
                    }))

                })

            },

            AddNewRule() { 

                var myself = this
                  
                this.property.split(",").forEach(function(object, i) {
                    myself[object].push(Object.assign({}, "", {
                        "id":myself[object].length + 1,
                        "valor":""
                    }))
                })

            },

            DestroyRule( indice, id ) {

                var myself = this

                this.condicao.forEach(function(item, i, list) {
                    if( item.id == id ) {
                        myself.property.split(",").forEach(function(object) {
                            myself[object].splice( indice, 1 )
                        })
                    }
                }) 
            },

            AddRules( rules ) {

                var self = this
                
                this.CleanRules()
                
                if( rules.length != 0 ) {
                    
                    var data = JSON.parse(rules);

                    data.forEach(function( item, j, list ) {
                        self.property.split(",").forEach(function(object, i) {
                            self[object].push(Object.assign({}, "", {
                                "id":list[j]["id"],
                                "valor":list[j][object]
                            }))
                        })
                    })
                }


            },

            CleanRules() {

                var self = this

                this.property.split(",").forEach(function(field, i, list) {
                    self[field] = []
                })

            }

        }

    }
</script>