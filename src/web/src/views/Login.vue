<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div class="p-col-fixed"  style="width:450px;">
                <div class="card p-fluid">
                    <div>
                        <h5 class="h2">Entrar</h5>
                        <div class="p-field">
                            <label for="name1">Login</label>
                            <InputText id="name1" type="text" />
                        </div>
                        <div class="p-field">
                            <label for="email1">Senha</label>
                            <InputText id="email1" type="password" />
                        </div>
                        <Button label="Login" class="p-mr-2 p-mb-2"/>
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
      criar: false,
      erros: []
    };
  },
  methods: {

  }
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
