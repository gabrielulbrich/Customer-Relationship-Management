<template>
		<div class="p-grid p-mt-6 p-jc-center">
			<div class="p-col-fixed"  style="width:400px;">
                <div class="card p-fluid">
                    <div v-if="!criar">
                        <h5>Entrar</h5>
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
                            <Button label="esqueci minha senha" class="p-button-secondary p-button-text p-mr-3" />
                            <Button @click="criar = true" label="ainda não tenho uma conta" class="p-button-secondary p-button-text p-ml-3" />
                        </div>
                    </div>
                    <CadastrarUsuarioForm v-else v-on:criar="voltarLogin">
                        <Button label="Criar Usuário" class="p-mr-2 p-mb-2"/>
                    </CadastrarUsuarioForm>
                </div>
			</div>
		</div>
</template>

<script>
import CadastrarUsuarioForm from "@/components/CadastrarUsuarioForm.vue";

export default {
  name: "Login",
  components: { CadastrarUsuarioForm },
  data() {
    return {
      criar: false,
      erros: []
    };
  },
  methods: {
      voltarLogin() {
          this.criar = false
      }
  }
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
