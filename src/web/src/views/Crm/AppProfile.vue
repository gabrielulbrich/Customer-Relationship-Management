<template>
	<div class="layout-profile">
		<div>
			<img :src="avatar" alt="" />
		</div>
		<button class="p-link layout-profile-link" @click="onClick">
			<span class="username">{{ name }}</span>
			<i class="pi pi-fw pi-cog"></i>
		</button>
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