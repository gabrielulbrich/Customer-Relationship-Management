<template>
  <div class="p-grid p-fluid dashboard">
    <div v-if="isInactive">
      <Toast/>
      <p>Solicitar uma nova aprovação</p>
      <Button label="Solicitar" class="p-mr-2 p-mb-2" @click.prevent="newRequest"></Button>
    </div>
    <div v-else-if="isInApproval">
      <p>Seu cadastro está em aprovação. Verifique com o administrador do site.</p>
    </div>
    <div v-if="report && !isAnonymous" class="p-grid p-fluid dashboard">
      <div class="p-col-12 p-md-6 p-xl-3">
        <div class="highlight-box">
          <div class="initials" style="background-color: #007be5; color: #00448f"><span>TV</span></div>
          <div class="highlight-details ">
            <i class="pi pi-search"></i>
            <span>Últimos 7 dias</span>
            <span class="count">{{ report.last7days }}</span>
          </div>
        </div>
      </div>
      <div class="p-col-12 p-md-6 p-xl-3">
        <div class="highlight-box">
          <div class="initials" style="background-color: #ef6262; color: #a83d3b"><span>TI</span></div>
          <div class="highlight-details ">
            <i class="pi pi-question-circle"></i>
            <span>Total de Leads</span>
            <span class="count">{{ report.allLeads }}</span>
          </div>
        </div>
      </div>
      <div class="p-col-12 p-md-6 p-xl-3">
        <div class="highlight-box">
          <div class="initials" style="background-color: #20d077; color: #038d4a"><span>OI</span></div>
          <div class="highlight-details ">
            <i class="pi pi-filter"></i>
            <span>Leads novos</span>
            <span class="count">{{ report.newLeads }}</span>
          </div>
        </div>
      </div>
      <div class="p-col-12 p-md-6 p-xl-3">
        <div class="highlight-box">
          <div class="initials" style="background-color: #f9c851; color: #b58c2b"><span>CI</span></div>
          <div class="highlight-details ">
            <i class="pi pi-check"></i>
            <span>Leads Fechados</span>
            <span class="count">{{ report.closedLeads }}</span>
          </div>
        </div>
      </div>

      <div v-if="activity && !isAnonymous" class="p-col-12 p-lg-6">
        <Panel header="Assinados para mim" style="height: 100%">
          <div class="activity-body">
            <div class="p-grid">
              <div class="p-col-12">
                <div v-for="(ac, index) in activity" :key="index">
                  <router-link :to="'/lead/'+ac.id">{{ ac.summary }} #{{ac.id}}<img :src="ac.priority_icon" alt="Icone prioridade"></router-link>
                </div>
              </div>
            </div>
          </div>
        </Panel>
      </div>
    </div>
  </div>
</template>

<script>
import { api } from "@/services.js";
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
            report: [],
            activity: [],
            errors: []
    }
  },
  created() {
        this.errors = [];
        api.get(`/lead/report`)
        .then((response) => {
            this.activity = response.data.activity;
            this.report = response.data.report;
        })
        .catch(error => {
            console.log('error', error)
            this.errors.push(error.response);
        });
  },
  methods: {
    async newRequest() {
      try{
				await api.post(`/page/new-request`, this.new_account)
				.then(response => {
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Sua solicitação foi enviada.`, life: 3000});
        })
        await this.$store.dispatch("me");
			} catch(error){
        this.$toast.add({severity:'error', summary: 'Sucesso', detail: `${error.response.data}`, life: 3000});
      }
    },
  },
  computed: {
    ...mapGetters([
      'isAdmin',
      'isMaster',
      'isUser',
      'isAnonymous',
      'isInactive',
      'isInApproval'
    ]),
  }
}
</script>

<style lang="scss" scoped>

.activity-body{
    img{
        width: 15px;
        height: 15px;
        float: right;
    }
}
</style>
