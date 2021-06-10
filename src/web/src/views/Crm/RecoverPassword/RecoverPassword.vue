<template>
<div class="p-grid p-mt-6 p-jc-center">
  <Toast />
  <div class="p-col-fixed"  style="width:450px;">
    <div class="card p-fluid">
      <div>
        <h5 class="h2">Recuperar senha</h5>
        <div class="p-field">
            <Password weakLabel="Senha Fraca" mediumLabel="Senha Média" strongLabel="Senha Forte" showIcon="pi pi-check" type="password" placeholder="informe a nova senha" :class="{'p-invalid': errors.length && errors[0].password}" v-model="recover_password.password" />
            <small class="p-invalid" v-if="errors.length && errors[0].password">{{ errors[0].password[0] }}</small>
        </div>
        <div class="p-field">
            <Password weakLabel="Senha Fraca" mediumLabel="Senha Média" strongLabel="Senha Forte" showIcon="pi pi-check" type="password" placeholder="confirme a nova senha" :class="{'p-invalid': errors.length && errors[0].password_confirmation}" v-model="recover_password.password_confirmation" />
            <small class="p-invalid" v-if="errors.length && errors[0].password_confirmation">{{ errors[0].password_confirmation[0] }}</small>
            <small class="p-invalid" v-if="errors.length && errors[0].invalid_token">{{ errors[0].invalid_token[0] }}</small>
        </div>
        <Button label="Trocar senha" class="p-mr-2 p-mb-2" @click.prevent="recoverPassword" />
        <div class="p-d-flex p-mt-3">
            <Button label="voltar" class="p-button-secondary p-button-text p-text-left" @click="$router.push('/login')" />
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import { api } from "@/services.js";
export default {
  name: "RecoverPassword",
  data() {
    return {
      recover_password: {
        password: "",
        password_confirmation: "",
        token: ""
      },
      errors: []
    };
  },
  created() {

	},
  methods: {
    recoverPassword() {
      this.recover_password.token = this.$route.params.token;

      api.post(`/reset-password`, this.recover_password)
      .then(response => {
        this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Senha Alterada, faça login novamente.`, life: 3000});
      }).catch(error => {
        this.errors = [];
        this.errors.push(error.response.data)
      })
    }
  },
}
</script>

<style lang="scss">
@import '@/App.scss';
</style>
