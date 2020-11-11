<template>
    <div class="p-grid p-mt-6 p-jc-center">
        <div class="p-col-fixed"  style="width:450px;">
            <div class="card p-fluid">
                <div>
                    <h5>Cadastre-se</h5>
                    <p>Preencha as informações abaixo para criar sua conta:</p>
                    <!-- <div class="p-field">
                        <InputText id="name" placeholder="nome" type="text" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="name-help" v-model="register.name" />
                        <small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="cpf" placeholder="cpf" type="text"  :class="{'p-invalid': errors.length && errors[0].cpf}" aria-describedby="cpf-help" v-model="register.cpf"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].cpf">{{errors[0].cpf[0]}}</small>
                    </div>
                    <p>Informações de acesso:</p>
                    <div class="p-field">
                        <InputText id="email" placeholder="email" type="email"  :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="email-help" v-model="register.email"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].email">{{errors[0].email[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="password" placeholder="senha" type="password" :class="{'p-invalid': errors.length && errors[0].password}" aria-describedby="password-help" v-model="register.password"/>
                    </div>
                    <div class="p-field">
                        <InputText id="password_confirmation" placeholder="confirme sua senha" type="password"  :class="{'p-invalid': errors.length && errors[0].password}" aria-describedby="password_confirmation-help" v-model="register.password_confirmation"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].password">{{errors[0].password[0]}}</small>
                    </div>
                    <div class="p-d-flex p-flex-column">
                        <Button label="Criar Usuário" class="p-mr-2 p-mb-2" @click.prevent="registerUser"/>
                        <router-link to="/login">
                        <Button label="voltar para área de login" class="p-button-secondary p-button-text" />
                        </router-link>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RegisterUser",
    data() {
        return {
            register: {
                nome: "",
                cpf: "",
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
            this.$router.push({ name: "dashboard" });
        },
        async registerUser(){
            this.errors = [];
            try {
                await this.$store.dispatch("registerUser", this.register);
                await this.$store.dispatch("loginUser", {email: this.register.email, password: this.register.password })
                await this.redirectToDashBoard();
            } catch (error) {
                this.errors.push(error.response.data);
            }
        }
  }
};
</script>

<style scoped>

</style>
