<template lang="html" src="../../views/politica/campos.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/"></style> -->
<script>
    export default {
        
        data() {
            return {

                // component
                form: "",
                perso: "",

                // model
                model: [

                    {
                        "id":"1",
                        "text":"Titulo",
                        "slug":"titulo"
                    },

                    {
                        "id":"2",
                        "text":"Imagem",
                        "slug":"imagem"
                    },

                    {
                        "id":"3",
                        "text":"Preço",
                        "slug":"preco"
                    },

                    {
                        "id":"4",
                        "text":"Curta Descrição",
                        "slug":"descricao"
                    },

                ]
            }
        },

        mounted() {

            this.form = this.$root.$refs.policy.$refs.form
            this.perso = this.form.$refs.perso

            if( this.model.length != 0 ) {

                $("input[type='checkbox']").iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });

                $("input[name='titulo']").iCheck('check')
                this.form.model.campos.push( this.model[0] )
                
            }

            this.AddFormModelCampos()

        },

        methods: {

            AddFormModelCampos() {

                var myself = this

                $("input[type='checkbox']").off("click").on('ifClicked', function(event){

                    var id = $(this).val(), 
                        count = 0,
                        slug = ""
                    
                    if( myself.form.model.campos.length ) {
                        myself.form.model.campos.forEach(function(item, i, list) {
                            if( list[i]["id"] == id ) {   
                                slug = list[i]["slug"]
                                list.splice(i, 1)
                                count = 1
                            }
                        })
                    }
                    
                    if( myself.perso.model.length != 0 ) { 

                        myself.perso.model.forEach(function( item, i, list ) {
                            delete list[i][slug]
                        })

                    }
                   
                    if( count == 1 ) {

                        count = 0

                    }else{

                        myself.perso.model.forEach(function( item, i, list ) {
                            list[i] = Object.assign({}, list[i], {[myself.model[parseInt(id)-1].slug]:""})
                        })
                        
                        myself.model.forEach(function(item, i, list){
                            if(item.id == id) {
                                myself.form.model.campos.push({
                                    "id":item.id,
                                    "text":item.text,
                                    "slug":item.slug,
                                })
                            }
                        })

                    }

                })

            },

            Checked( data ) {

                data.forEach(function( item, i ) {
                    $("input[name='"+ item.slug +"']").iCheck('check')
                })

            },

        }

    }
</script>