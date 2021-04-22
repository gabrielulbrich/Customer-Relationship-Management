<template>
	<div class="p-grid crud-demo">
		<div class="p-col-12">
			<div class="card">
				<h5>Customização de APIS</h5>
				<Accordion>
          <div v-for="(api, index) in apis" :key="index">
            <AccordionTab :header="api.api">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </AccordionTab>
          </div>
				</Accordion>
			</div>
		</div>
	</div>

</template>

<script>
import { api } from "@/services.js";

export default {
	data() {
		return {
      apis: [],
			errors: [],
		}
	},
	created() {
    this.loadApis();
	},
	mounted() {
	},
	methods: {
		loadApis(){
			api.get("/api/get-all")
			.then((response) => {
				this.apis = response.data.apis;
        console.log(this.apis)
			})
		},
	}
}
</script>

<style scoped lang="scss">
	/deep/ .p-card .p-card-title {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 0;
	}
</style>
