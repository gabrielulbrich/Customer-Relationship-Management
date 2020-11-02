<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div class="p-col-fixed"  style="width:450px;">
        
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
                <div class="p-d-flex p-jc-between p-mt-3">
                    <Button label="esqueci minha senha" class="p-button-secondary p-button-text p-text-left" />
                </div>
            </div>
        </div>
			</div>
		</div>
</template>

<script>

export default {
  name: "Login",
  data() {
    return {
      login: {
        email: "",
        password: ""
      },
      criar: false,
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
    }
  },
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
