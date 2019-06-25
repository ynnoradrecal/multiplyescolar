<template lang="html">
    <fieldset >

        <div class="col-xs-12">
            <legend>Contato</legend>
        </div>

        <div class="form-group" v-bind:class="{'has-error':error.email_to}">
            <div class="col-xs-12">
                <label for="">Enviar Emails Para:</label>
                <input class="form-control" placeholder="..." type="text" v-model="store.email_to">
                <span class="help-block" v-for="error in error.email_to">{{ error }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4 col-sm-4 col-xs-12" v-bind:class="{'has-error':error.email_from}">
                <label for="">Remetente de Email:</label>
                <input class="form-control" placeholder="..." type="text" v-model="store.email_from">
                <span class="help-block" v-for="error in error.email_from">{{ error }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4 col-sm-4 col-xs-12" v-bind:class="{'has-error':error.email_layout}">
                <label for="">Modelo de Email:</label>
                <input class="form-control" placeholder="..." type="text" v-model="store.email_layout">
                <span class="help-block" v-for="error in error.email_layout">{{ error }}</span>
            </div>
        </div>

        <br>
        {/*<fieldset>

            <div class="col-xs-12">
                <legend>Responsável</legend>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12" v-bind:class="{'has-error':error.responsavel}">
                    <label for="">Nome:</label>
                    <input class="form-control" placeholder="Nome do responsável" type="text" v-model="store.responsavel">
                    <span class="help-block" v-for="error in error.responsavel">{{ error }}</span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12" v-bind:class="{'has-error':error.email}">
                    <label for="">Email:</label>
                    <input class="form-control" placeholder="Email do responsável" type="text" v-model="store.email">
                    <span class="help-block" v-for="error in error.email">{{ error }}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12" v-bind:class="{'has-error':error.telefone}">
                    <label for="">Telefone:</label>
                    <input class="form-control" v-mask="'## ####-####'" placeholder="..." type="text" v-model="store.telefone">
                    <span class="help-block" v-for="error in error.telefone">{{ error }}</span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="">Celular:</label>
                    <input class="form-control" v-mask="'## # ####-####'" placeholder="..." type="text" v-model="store.celular">
                </div>
            </div>
        </fieldset>

        <br>
        <fieldset>
            <div class="col-xs-12">
                <legend>Endereço</legend>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-4 col-xs-12" v-bind:class="{'has-error':error.cep}">
                    <label for="">CEP:</label>
                    <input class="form-control" v-mask="'#####-###'" placeholder="..." type="text" v-model="store.cep">
                    <span class="help-block" v-for="error in error.cep">{{ error }}</span>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12" v-bind:class="{'has-error':error.numero}">
                    <label for="">Numero:</label>
                    <input class="form-control" placeholder="..." type="text" v-model="store.numero">
                    <span class="help-block" v-for="error in error.numero">{{ error }}</span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <label for="">Complemento:</label>
                    <input class="form-control" placeholder="..." type="text" v-model="store.complemento">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12" v-bind:class="{'has-error':error.logradouro}">
                    <label for="">Endereço:</label>
                    <input class="form-control" placeholder="..." type="text" v-model="store.logradouro">
                    <span class="help-block" v-for="error in error.logradouro">{{ error }}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-5 col-sm-5 col-xs-12" v-bind:class="{'has-error':error.bairro}">
                    <label for="">Bairro:</label>
                    <input class="form-control" placeholder="..." type="text" v-model="store.bairro">
                    <span class="help-block" v-for="error in error.bairro">{{ error }}</span>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12" v-bind:class="{'has-error':error.estado}">
                    <label for="">Estado:</label>
                    <select class="form-control" v-model="store.estado">
                        <option>...</option>
                        <option :value="item.nome" v-for="item in list.estados">{{ item.nome }}</option>
                    </select>
                    <span class="help-block" v-for="error in error.estado">{{ error }}</span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12" v-bind:class="{'has-error':error.cidade}">
                    <label for="">Cidade:</label>
                    <input class="form-control" placeholder="..." type="text" v-model="store.cidade">
                    <span class="help-block" v-for="error in error.cidade">{{ error }}</span>
                </div>
            </div>
        </fieldset>
        <br>
        <fieldset>
            <div class="col-xs-12">
                <legend>Descrição</legend>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea class="form-control" rows="3" placeholder="Descrição..." v-model="store.descricao"></textarea>
                </div>
            </div>
        </fieldset>*/}
    </fieldset>
</template>
<script>
export default {

    data() {
        return {

            status: false,
            error: [],
            list: { contatoConfig:[] },
            store: {
                id: null,
                email_to: "",
                email_from: "",
                email_layout: "",                
                form: "contato"
            }
        }
    },

    methods: {

        get_configuration() {

            var host     = this.$root.$refs.configloja.host
            var resource = this.$resource( host +"/configuracao/contato/get" )

            this.list.contatoConfig = []

            resource.show( ).then(function( response ) {
                this.list.contatoConfig = response.data
            })

        }
    }

}
</script>