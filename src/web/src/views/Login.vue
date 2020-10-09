<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div class="p-col-fixed"  style="width:450px;">
        
        <div class="card p-fluid">
            <div>
                <h5 class="h2">Entrar</h5>
                <div v-if="errors.length && errors[0].email" class="p-field">
                    <InputText id="email" type="email" placeholder="informe seu e-mail" v-model="login.email" class="p-error" aria-describedby="username-help"/>
                    <small id="username-help" class="p-error">Digite um e-mail valido.</small>
                </div>
                <div v-else class="p-field">
                    <InputText id="email" type="email" placeholder="informe seu e-mail" v-model="login.email"/>
                </div>
                <div class="p-field">
                    <InputText id="password" type="password" placeholder="informe sua senha" v-model="login.password" />
                </div>
                <small v-if="errors.length && errors[0].auth" id="username-help" class="p-error">E-mail ou senha incorretos.</small>
                <Button label="Login" class="p-mr-2 p-mb-2" @click.prevent="loginUser" />
                <div class="p-d-flex p-jc-between p-mt-3">
                    <Button label="esqueci minha senha" class="p-button-secondary p-button-text p-text-left" />
                    <router-link to="/registrar" style="width: 430px;">
                        <Button label="ainda não tenho uma conta" class="p-button-secondary p-button-text p-text-right" />
                    </router-link>
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
        this.errors.push(error.response.data.error);
      }
    }
  },
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
