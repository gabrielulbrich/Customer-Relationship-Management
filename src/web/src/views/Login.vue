<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div v-if="!forgot && !new_account_page" class="p-col-fixed"  style="width:450px;">
        <div class="card p-fluid">
            <div>
                <h5 class="h2">Entrar</h5>
                <div class="p-field">
                    <InputText id="email" type="email" placeholder="informe seu e-mail" v-model="login.email" :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="username-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].email">{{ errors[0].email[0] }}</small>
                </div>
                <div class="p-field">
                    <InputText id="password" type="password" placeholder="informe sua senha" :class="{'p-invalid': errors.length && errors[0].password}" v-model="login.password" />
                    <small class="p-invalid" v-if="errors.length && errors[0].password">{{ errors[0].password[0] }}</small>
                    <small class="p-invalid" v-else-if="errors.length && errors[0].error">{{ errors[0].error.auth }}</small>
                </div>
                <Button label="Login" class="p-mr-2 p-mb-2" @click.prevent="loginUser" />
                <div class="p-d-flex p-mt-3">
                    <Button label="esqueci minha senha" class="p-button-secondary p-button-text p-text-left" @click="forgot = true" />
                </div>
                <div class="p-d-flex p-mt-3">
                    <Button label="cadastrar nova conta" class="p-button-secondary p-button-text p-text-left" @click="new_account_page = true" />
                </div>
            </div>
        </div>
			</div>
      <div v-else-if="new_account_page" class="p-col-fixed"  style="width:450px;">
        <div class="card p-fluid">
            <div>
              <h5 class="h2">Cadastrar novo usuário</h5>
                <div class="p-field">
                    <InputText id="name" type="name" placeholder="informe seu nome" v-model="new_account.name" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="username-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].name">{{ errors[0].name[0] }}</small>
                </div>
                <div class="p-field">
                    <InputText id="email" type="email" placeholder="informe seu e-mail" v-model="new_account.email" :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="email-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].email">{{ errors[0].email[0] }}</small>
                </div>
                <div class="p-field">
                    <InputMask mask="999.999.999-99" id="cpf" placeholder="informe seu cpf" v-model="new_account.cpf" type="text"  :class="{'p-invalid': errors.length && errors[0].cpf}" aria-describedby="cpf-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].cpf">{{errors[0].cpf[0]}}</small>
                </div>
                <div class="p-field">
                    <InputText id="site_name" type="site_name" placeholder="informe o site" v-model="new_account.site_name" :class="{'p-invalid': errors.length && errors[0].site_name}" aria-describedby="usersite_name-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].site_name">{{ errors[0].site_name[0] }}</small>
                </div>
                <div class="p-field">
                    <InputText id="password" type="password" placeholder="informe sua senha" :class="{'p-invalid': errors.length && errors[0].password}" v-model="new_account.password" />
                    <small class="p-invalid" v-if="errors.length && errors[0].password">{{ errors[0].password[0] }}</small>
                </div>
                <div class="p-field">
                    <InputText id="password_confirmation" type="password_confirmation" placeholder="informe sua senha" :class="{'p-invalid': errors.length && errors[0].password_confirmation}" v-model="new_account.password_confirmation" />
                    <small class="p-invalid" v-if="errors.length && errors[0].password_confirmation">{{ errors[0].password_confirmation[0] }}</small>
                    <small class="p-invalid" v-else-if="errors.length && errors[0].error">{{ errors[0].error.auth }}</small>
                </div>
                <Button label="Cadastrar novo usuário" class="p-mr-2 p-mb-2" @click.prevent="newAccount" />
                <div class="p-d-flex p-mt-3">
                    <Button label="voltar" class="p-button-secondary p-button-text p-text-left" @click="new_account_page = false" />
                </div>
            </div>
        </div>
      </div>
      <div v-else-if="forgot" class="p-col-fixed"  style="width:450px;">
        <div class="card p-fluid">
            <div>
                <h5 class="h2">Recuperar senha</h5>
                <div class="p-field">
                    <InputText id="email" type="email" placeholder="informe seu e-mail" v-model="login.email" :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="username-help"/>
                    <small class="p-invalid" v-if="errors.length && errors[0].email">{{ errors[0].email[0] }}</small>
                </div>
                <Button label="Trocar senha" class="p-mr-2 p-mb-2" @click.prevent="loginUser" />
                <div class="p-d-flex p-mt-3">
                    <Button label="voltar" class="p-button-secondary p-button-text p-text-left" @click="forgot = false" />
                </div>
            </div>
        </div>
			</div>
		</div>
</template>

<script>
import { api } from "@/services.js";
export default {
  name: "Login",
  data() {
    return {
      login: {
        email: "",
        password: "",
      },
      new_account: {
        name: "",
        email: "",
        site_name: "",
        password: "",
        password_confirmation: "",
        cpf: 0,
      },
      forgot: false,
      new_account_page: false,
      errors: []
    };
  },
  methods: {
    redirectToDashBoard() {
      this.$router.push({ path: this.$store.getters.pageName });
    },
    async loginUser() {
      try{
        await this.$store.dispatch("loginUser", this.login);
        await this.redirectToDashBoard();
      } catch (error) {
        this.errors = [];
        this.errors.push(error.response.data);
      }
    },
    async newAccount() {
			try{
				await api.post(`/new-account`, this.new_account)
				.then(response => {
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} criado.`, life: 3000});
        })
        await this.$store.dispatch("loginUser", { email: this.new_account.email, password: this.new_account.password });
        await this.redirectToDashBoard();
			} catch(error){
        this.errors = [];
				this.errors.push(error.response.data)
      }
    }
  },
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
