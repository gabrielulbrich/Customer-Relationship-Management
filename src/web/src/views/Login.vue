<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div class="p-col-fixed"  style="width:450px;">
                <div class="card p-fluid">
                    <div>
                        <h5 class="h2">Entrar</h5>
                        <div class="p-field">
                            <label for="email">Login</label>
                            <InputText id="email" type="email" v-model="login.email" />
                        </div>
                        <div class="p-field">
                            <label for="password">Senha</label>
                            <InputText id="password" type="password" v-model="login.password" />
                        </div>
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
      erros: []
    };
  },
  methods: {
    redirectToDashBoard() {
      this.$router.push({ name: "dashboard" });
    },
    async loginUser() {
      try{
        await this.$store.dispatch("loginUser", this.login)
        await this.$store.dispatch("getUser");
        await this.redirectToDashBoard();
      } catch (error) {
        this.erros.push(error.response.data.message);
      }
    }
  },
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
