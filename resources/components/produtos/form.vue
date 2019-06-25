<template lang="html" src="../../views/produtos/form.html"></template>
<!-- <style lang="sass" src="../../assets/admin/sass/components/produtos.scss"></style> -->
<script>

    import PulseLoader from "../plugins/vue-spinner.vue"
    import Regras from "./regras.vue"
    import Politica from "./politica.vue"
    import Entrega from "./entrega.vue"
    import AwesomeMask from 'awesome-mask'
    import Upload from "./upload.vue";

    export default {

        components: { PulseLoader, Regras, Politica, Entrega, Upload },

        directives: {
            'mask': AwesomeMask
        },

        props: ['host', 'url'],

        data() {
			return {
				
				title: "Nova Repositório",

				error: [],

				// components
                root: "",
                list: "",
                regras: "",
                policy: "",
                delivery: "",

				// booleano
				bool: {
                    load: false,
                },

                getts: {
                    events: [],
                    alunos: []
                },

				// value form
				model: {
                    event_id: "",
                    aluno_id: "",
                    instituicao_id: '',
                    nome: "",
                    pin: "",
                    status: 0,
                    foto_unit_val: "",
                    policys: [],
                    regras: [],
                    delivery: [],
                    descricao: ""
				}

			}
		},

        mounted() {

			this.root = this.$root.$refs.product
			this.list = this.root.$refs.list
            this.policy = this.root.$refs.form.$refs.policy
            this.regras = this.root.$refs.form.$refs.regras
            this.delivery = this.root.$refs.form.$refs.entrega

            // plugins jquery
            this.ICheck()

            this.getQueryResource("getEvents", "events")
            this.getQueryResource("getAlunos", "alunos")

		},

        methods: {

            Store() {

				this.bool.load = true

                this.model.policys = this.policy.model // get policys
                this.model.delivery = this.delivery.model // get entrega

                if( this.delivery.instituicao_id == 0 ) {
                    this.model.instituicao_id = 0;
                }else{
                    this.model.instituicao_id = this.delivery.instituicao_id;
                }

                this.regras.BuildRulesObject() // get rules
                
				this.QueryResource( this.$resource( this.root.host +"/init" ), "insert", "save" )

			},

			Put() {
				
				this.bool.load = true

                this.model.policys = this.policy.model // get policys
                this.model.delivery = this.delivery.model // get entrega

                if( this.delivery.instituicao_id == 0 ) {
                    this.model.instituicao_id = 0;
                }else{
                    this.model.instituicao_id = this.delivery.instituicao_id;
                }

                this.regras.BuildRulesObject() // get rules

				this.QueryResource( this.$resource( this.root.host +"/init" ), "update", "put" )

			},

			Destroy( setting ) {
				
				var myself = this

				this.$swal( setting ).then(function() {

					myself.bool.load = true		

                    myself.model.policys = myself.policy.model // get policys
                    myself.regras.BuildRulesObject() // get rules

					myself.QueryResource( myself.$resource( myself.root.host +"/init" ), "delete", "destroy" )

				})

			},

            QueryResource( src, type, method ) {

				src.save( {"post":this.model, "methods":method} ).then(function( res ) {

                    var data = res.data;

					if( data.status != 0 ) {
                        this.Alert( res.data.alert );
                        this.list.RefreshDataTable()
                    }

					this.Error([])
					this.bool.load = false

					if(["delete", "insert"].indexOf(type) >= 0) {
                        this.root.ResetGlobal()
					}

                    $('.delivery').find('li:eq(0) input[type="checkbox"]').iCheck('check');

					
				}, function( res ) {

					this.Error( res.data )

					this.bool.load = false

				})

			},

            getQueryResource( method, field ) {
                
                var src = this.$resource( this.root.host +"/init" )
                src.get({"methods":method}).then(function( res ) {
                    this.getts[field] = res.data.data
                })

            },

            CreatPin() {
                    
                this.model.pin = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000

            },

            Alert( data ) {
				this.$swal(data.title, data.text, data.type)
			},

			Error( data ) {

                if(data.length == 0) {
                    this.error = []
                }else{

					this.error = []
                    
                    for( var item in data ) {
                        this.error = Object.assign({}, this.error, {
                            [item.replace("post.", "")]:[data[item][0]]
                        })
                    }

                }

                this.bool.load = false

            },

			CleanModel() {

                for( var item in this.model ) {

                    this.model[item] = ""

                }

                this.model.status = 0
				this.model.regras = []
				this.model.policys = []

                $("input[type='checkbox']").iCheck('uncheck')

            },

            ICheck() {

                var myself = this

                $("input[type='checkbox']").iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });

                $("input[name='status']").on('ifClicked', function(event){

                    if( myself.model.status == 1 ) {
                        myself.model.status = 0
                        return false
                    }

                    myself.model.status = 1

                })

            }

        }

    }
</script>