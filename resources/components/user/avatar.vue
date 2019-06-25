<template lang="html">
    <div class="col-xs-12">
        <div class="form-group">
            <legend> Avatar </legend>
           
                <div v-show="bool.open" class="file">
                    <img alt="" :src="file.url">
                </div>

                <pulse-loader v-show="bool.load" class="loader_form"></pulse-loader>
                <div v-show="bool.anexar" class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                        <span>Anexar</span>
                    <input id="fileupload" type="file" name="foto[]">
                </div>

                <!-- The fileinput-button span is used to style the file input field as button -->
                <div v-show="bool.remove" class="remove-button">
                    <button @click="destroyAvatar" type="button" class="btn btn-danger cancel">
                        <i class="glyphicon glyphicon-trash"></i><span> Remover</span>
                    </button>
                </div>
                
            
        </div>
    </div>
</template>

<script>

    import PulseLoader from "../plugins/vue-spinner.vue"

    export default {

        components: { PulseLoader }, 

        props: ["file"],

        data() {
            return {

                root: "",
                list: "",
                form: "",
                
                resource: "",

                bool: {
                    open: false,
                    anexar: false,
                    remove: false,
                    load: false,
                },

            }
        },

        mounted() {

            this.root = this.$root.$refs.user
            this.list = this.root.$refs.list
            this.form = this.root.$refs.form

            this.resource = this.$resource( this.root.host +"/init" )

            this.Bool(["anexar"])
            this.uploadAvatar()

        },

        methods: {


            Bool( arr ) {

                var self = this

                for( var item in this.bool ) {
                    this.bool[item] = arr.indexOf( item ) != -1 ? true : false
                }

            },

            destroyAvatar() {
                
                this.bool.load = true

                this.resource.save(
                    {
                        "methods": "destroyAvatar", 
                        "file": this.form.model.foto, 
                        "id": this.form.model.id
                    }
                ).then(function( response ) {

                    var self = this

                    this.form.model.foto.url = ""

                    this.list.data.forEach(function( item, i ) {   
                        if( item.id == self.form.model.id ) {
                            self.list.data[i].foto = ""
                        }
                    }) 

                    this.Bool(["anexar"])

                })

            },


            uploadAvatar() {

                var self = this, form = this.$root.$refs.user.$refs.form

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': Laravel.csrfToken
                    }
                });

        
                $('#fileupload').fileupload({
                    url: this.root.host +"/avatar",
                    dataType: 'json',
                    beforeSend: function(){ 
                        self.bool.load = true
                    },
                    done: function (e, data) {

                        var data = data.result
                        
                        for( var item in data ){
                            form.model.foto[item] = data[item]
                        }

                        console.log( form.model.foto )

                        self.Bool(["open", "remove"])

                        self.load = false

                    },

                });

            },

        }

    }
</script>

<style lang="sass">
    .file {
        width: 200px; height: 200px; overflow: hidden;
        img {
            width: 100%;
        }
    }
    .fileinput-button, .remove-button { margin: 10px 0 0; }
</style>