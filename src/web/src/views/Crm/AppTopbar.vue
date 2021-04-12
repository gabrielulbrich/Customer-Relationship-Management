<template>
	<div class="layout-topbar">
		<button class="p-link layout-menu-button" @click="onMenuToggle">
			<span class="pi pi-bars"></span>
		</button>
		<div class="layout-topbar-icons">
			<button class="p-link">
				<span class="layout-topbar-item-text">Notificações</span>
				<span class="layout-topbar-icon pi pi-bell" @click="toggle" aria-controls="overlay_panel"></span>
				<span class="layout-topbar-badge">{{ countNotification }}</span>
        <OverlayPanel ref="op" appendTo="body" :showCloseIcon="true" id="overlay_panel" style="width: 300px;" :breakpoints="{'960px': '75vw'}">
        <Toast position="bottom-right" />
        <div v-if="countNotification == 0">
		  	  <span>Nenhuma notificação nova</span>
		    </div>
        <div v-else>
          <div class="notification" v-for="notification in notifications" :key="notification.id">
            <p>{{ notification.name }} deseja fazer parte da página</p>
            <Button label="Aceitar" class="p-button-raised p-mr-2 p-mb-2" @click.prevent="answerNotification(notification.id, true)"/>
				    <Button label="Recusar" class="p-button-secondary p-mr-2 p-mb-2" @click.prevent="answerNotification(notification.id, false)"/>
          </div>
        </div>
        </OverlayPanel>

			</button>
			<button class="p-link">
				<span class="layout-topbar-item-text">Settings</span>
				<span class="layout-topbar-icon pi pi-cog"></span>
			</button>
			<button class="p-link">
				<span class="layout-topbar-item-text">User</span>
				<span class="layout-topbar-icon pi pi-user"></span>
			</button>
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import { api } from "@/services.js";

export default {
	data() {
		return {
      notifications: [],
      errors: [],
		}
	},	
  methods: {
    onMenuToggle(event) {
      this.$emit('menu-toggle', event);
    },
    toggle(event) {
      this.$refs.op.toggle(event);
    },
    loadNotifications() {
      if (this.isAdmin) {
        api.get('/page/get-notifications')
        .then(response =>  {
          this.notifications = response.data
        })
      }
    },
    async answerNotification(user_id, answer) {
      try{
				await api.post(`/page/answer-notification`, {user_id, answer})
				.then(response => {
          this.notifications = this.notifications.filter(val => val.id !== response.data.id);
          if (answer)
					  this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} aceito.`, life: 3000});
          else
            this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} rejeitado.`, life: 3000});
        })
			} catch(error){
        console.log(error)
        this.errors = [];
				this.errors.push(error.response.data)
      }
    },
    destroyDiv(id) {
      this.notifications = this.users.filter(val => val.id !== response.data.id);
    }
  },
  computed: {
    ...mapGetters([
      'isAdmin',
    ]),
    countNotification() {
      return Object.keys(this.notifications).length
    }
  },
  created(){
	  this.loadNotifications();
	},
}
</script>

<style lang="scss" scoped>
.notification {
  margin-bottom: 10px;
}
.notification p {
  margin-bottom: 0;
}
</style>