<template>
	<div class="p-grid crud-demo">
    <p>DATAAAA</p>
	</div>

</template>

<script>
import { api } from "@/services.js";
import { mapGetters } from 'vuex';

export default {
	data() {
		return {
    }
	},
	created() {
    this.loadApis();
	},
	mounted() {
	},
	methods: {
		
	},
  computed: {
    ...mapGetters([
      'pageName',
    ]),
  }
}
</script>

<style scoped lang="scss">

</style>
