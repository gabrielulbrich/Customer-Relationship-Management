<template>
	<div id="layout-config" :class="containerClass">
		<a href="#" class="layout-config-close" @click="hideConfigurator">
			<i class="pi pi-times"></i>
		</a>

		<div class="layout-config-content">

		</div>
	</div>
</template>

<script>
	export default {
		props: {
			active: {
				type: Boolean,
				default: false
			},
		},
		data() {
			return {
				d_active: this.active,
			}
		},
		watch: {
			$route() {
				if (this.d_active) {
					this.d_active = false;
				}
			},
			active() {
				this.d_active = !this.d_active
			}
		},
		outsideClickListener: null,
		methods: {
			hideConfigurator(event) {
				this.d_active = false;
				this.unbindOutsideClickListener();
				event.preventDefault();
			},
		},
		computed: {
			containerClass() {
				return ['layout-config', {'layout-config-active': this.d_active}];
			},
		}
	}
</script>
