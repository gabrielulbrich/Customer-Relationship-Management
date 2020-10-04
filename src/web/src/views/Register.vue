<template>
    <div class="p-grid p-mt-6 p-jc-center">
        <div class="p-col-fixed"  style="width:450px;">
            <div class="card p-fluid">
                <div>
                    <h5>Cadastre-se</h5>
                    <p>Preencha as informações abaixo para criar sua conta:</p>
                    <div v-if="errors.length && errors[0].name" class="p-field">
                        <InputText id="name" placeholder="nome" type="text" class="p-error" aria-describedby="name-help" v-model="register.name" />
                        <small id="name-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="name" placeholder="nome" type="text" v-model="register.name" />
                    </div>
                    <div v-if="errors.length && errors[0].cpf" class="p-field">
                        <InputText id="cpf" placeholder="cpf" type="text"  class="p-error" aria-describedby="cpf-help" v-model="register.cpf"/>
                        <small id="cpf-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="cpf" placeholder="cpf" type="text" v-model="register.cpf"/>
                    </div>
                    <div v-if="errors.length && errors[0].cep" class="p-field">
                        <InputText id="cep" placeholder="cep" type="text"  class="p-error" aria-describedby="cep-help" v-model="register.cep"/>
                        <small id="cep-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="cep" placeholder="cep" type="text" v-model="register.cep"/>
                    </div>
                    <div v-if="errors.length && errors[0].number" class="p-field">
                        <InputText id="number" placeholder="número da residência" type="text"  class="p-error" aria-describedby="number-help" v-model="register.number"/>
                        <small id="number-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="number" placeholder="número da residência" type="text" v-model="register.number"/>
                    </div>
                    <p>Site da loja:</p>
                    <div v-if="errors.length && errors[0].site" class="p-field">
                        <InputText id="site" placeholder="meusite.com.br" type="text" class="p-error" aria-describedby="site-help" v-model="register.site" />
                        <small id="site-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="site" placeholder="meusite.com.br" type="text" v-model="register.site" />
                    </div>
                    <p>Informações de acesso:</p>
                    <div v-if="errors.length && errors[0].email" class="p-field">
                        <InputText id="email" placeholder="email" type="email"  class="p-error" aria-describedby="email-help" v-model="register.email"/>
                        <small id="email-help" class="p-error">Campo obrigatório.</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="email" placeholder="email" type="email" v-model="register.email"/>
                    </div>
                    <div v-if="errors.length && errors[0].password" class="p-field">
                        <InputText id="password" placeholder="senha" type="password" class="p-error" aria-describedby="password-help" v-model="register.password"/>
                        <small id="password-help" class="p-error">Essas senhas não coincidem. Digite novamente</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="password" placeholder="senha" type="password" v-model="register.password"/>
                    </div>
                    <div v-if="errors.length && errors[0].password" class="p-field">
                        <InputText id="password_confirmation" placeholder="confirme sua senha" type="password"  class="p-error" aria-describedby="password_confirmation-help" v-model="register.password_confirmation"/>
                        <small id="password_confirmation-help" class="p-error">Essas senhas não coincidem. Digite novamente</small>
                    </div>
                    <div v-else class="p-field">
                        <InputText id="password_confirmation" placeholder="confirme sua senha" type="password" v-model="register.password_confirmation"/>
                    </div>
                    <div class="p-d-flex p-flex-column">
                        <Button label="Criar Usuário" class="p-mr-2 p-mb-2" @click.prevent="registerUser"/>
                        <router-link to="/login">
                        <Button label="voltar para área de login" class="p-button-secondary p-button-text" />
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapFields } from "@/helpers.js";
// import { getCep } from "@/services.js";

export default {
    name: "RegisterUser",
    data() {
        return {
            register: {
                nome: "",
                cpf: "",
                cep: "",
                number: "",
                site: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            errors: []
        };
    },
    methods: {
        redirectToDashBoard() {
            this.$router.push({ path: "/volvo" });
        },
        async registerUser(event){
            this.erros = [];
            const button = event.currentTarget;
            button.value = "Registrando...";
            button.setAttribute("disabled", "");
            try {
                await this.$store.dispatch("registerUser", this.register);
                await this.$store.dispatch("loginUser", this.register)
                await this.$store.dispatch("getUser");
                await this.redirectToDashBoard();
            } catch (error) {
                button.removeAttribute("disabled");
                button.value = "Criar Usuário";
                this.errors = [];
                this.errors.push(error.response.data.error);
            }
        }
        // preencherCep() {
        //     const cep = this.cep.replace(/\D/g, "");
        //     if (cep.length === 8) {
        //         getCep(cep).then(response => {
        //         this.rua = response.data.logradouro;
        //         this.bairro = response.data.bairro;
        //         this.estado = response.data.uf;
        //         this.cidade = response.data.localidade;
        //         });
        //     }
        // }
  }
};
</script>

<style scoped>

</style>
