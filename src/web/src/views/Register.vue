<template>
    <div class="p-grid p-mt-6 p-jc-center">
        <div class="p-col-fixed"  style="width:450px;">
            <div class="card p-fluid">
                <div>
                    <h5>Cadastre-se</h5>
                    <div class="p-field">
                        <label for="email">Email</label>
                        <InputText id="email" type="email" />
                    </div>
                    <div class="p-field">
                        <label for="password">Senha</label>
                        <InputText id="password" type="password" />
                    </div>
                    <div class="p-field">
                        <label for="password_confirm">Confirmar Senha</label>
                        <InputText id="password_confirm" type="password" />
                    </div>
                    <div class="p-field">
                        <label for="cep">Cep</label>
                         <InputText id="cep" type="text" v-model="cep"  /><!--keyup="preencherCep" -->
                    </div>
                    <div class="p-field">
                        <label for="street">Rua</label>
                        <InputText id="street" type="text" />
                    </div>
                    <div class="p-field">
                        <label for="number">Numero</label>
                        <InputText id="number" type="text" />
                    </div>
                    <div class="p-field">
                        <label for="neighborhood">Bairro</label>
                        <InputText id="neighborhood" type="text" />
                    </div>
                    <div class="p-field">
                        <label for="city">Cidade</label>
                        <InputText id="city" type="text" />
                    </div>
                    <div class="p-field">
                        <label for="state">Estado</label>
                        <InputText id="state" type="password" />
                    </div>
                    <div class="p-d-flex p-flex-column">
                        <Button label="Criar Usuário" class="p-mr-2 p-mb-2"/>
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
// import { mapFields } from "@/helpers.js";
// import { getCep } from "@/services.js";

export default {
    name: "CadastrarUsuarioForm",
//     computed: {
//         ...mapFields({
//             fields: [
//             "nome",
//             "email",
//             "password",
//             "password_confirm",
//             "street",
//             "cep",
//             "number",
//             "neighborhood",
//             "city",
//             "state"
//             ],
//             base: "usuario",
//             mutation: "UPDATE_USUARIO"
//         }),
//         // mostrarDadosLogin() {
//         //     return !this.$store.state.login || this.$route.name === "usuario-editar";
//         // }
//     },
//     data() {
//         return {
//         criar: true,
//         erros: []
//         };
//     },
//     methods: {
//         preencherCep() {
//             const cep = this.cep.replace(/\D/g, "");
//             if (cep.length === 8) {
//                 getCep(cep).then(response => {
//                 this.rua = response.data.logradouro;
//                 this.bairro = response.data.bairro;
//                 this.estado = response.data.uf;
//                 this.cidade = response.data.localidade;
//                 });
//             }
//         }
//   }
};
</script>

<style scoped>

</style>
