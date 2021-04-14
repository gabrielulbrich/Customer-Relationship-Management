<template>
	<div class="layout-profile">
		<div>
			<img :src="avatar" alt="" />
		</div>
		<button class="p-link layout-profile-link" @click="onClick">
			<span class="username">{{ name }}</span>
			<i class="pi pi-fw pi-cog"></i>
		</button>
		<div class="p-d-flex p-jc-center">
      <span v-if="isMaster" class="p-tag">Master</span>
      <span v-else-if="isAdmin" class="p-tag">Admin</span>
      <span v-else-if="isUser" class="p-tag">User</span>
			<span v-else-if="isAnonymous" class="p-tag p-tag-danger">Inativo</span>
		</div>
        <transition name="layout-submenu-wrapper">
            <ul v-show="expanded">
                <li><router-link class="p-link" :to="{name: 'profile'}"><button class="p-link"><i class="pi pi-fw pi-user"></i><span>Perfil</span></button></router-link></li>
                <li><button class="p-link"><i class="pi pi-fw pi-inbox"></i><span>Notifications</span><span class="menuitem-badge">2</span></button></li>
                <li><button class="p-link"><i class="pi pi-fw pi-power-off"></i><span>Logout</span></button></li>
            </ul>
        </transition>
	</div>
</template>

<script>
  import { mapGetters } from 'vuex';

	export default {
		data() {
			return {
				expanded: false
			}
		},
		methods: {
			onClick(event){
				this.expanded = !this.expanded;
				event.preventDefault();
			}
		},
		computed: {
			...mapGetters([
				'isAdmin',
				'isMaster',
				'isUser',
				'isAnonymous',
			]),
			avatar(){
				return this.$store.state.user.avatar
			},
			name(){
				return this.$store.state.user.name
			}
		}
	}
</script>

<style scoped>

</style>