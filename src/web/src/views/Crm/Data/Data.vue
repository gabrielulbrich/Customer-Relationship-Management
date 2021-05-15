<template>
	<div class="p-grid crud-demo">
    <Toast position="bottom-right" />
		<div class="p-col-12">
			<div class="card">
				<h5>Dados Salvos</h5>
				<Accordion>
          <div v-for="(api, index) in apis" :key="index">
            <AccordionTab>
              <template #header>
                <div class="p-d-flex p-jc-between" style="width: 100%">
                  <span>/{{pageName}}/{{ api.api }}</span>
                </div>
              </template>
              <DataTable :value="api.fields" editMode="cell" class="editable-cells-table" sortMode="single" :sortOrder="1">
                <Column field="name" header="Campo">

                </Column>
                <Column field="type.name" header="Tipo">

                </Column>
                <Column field="description" header="Descrição">

                </Column>
              </DataTable>
            </AccordionTab>
          </div>
				</Accordion>
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
    loadApis() {
			api.get("/api/get-all")
			.then((response) => {
        response.data.apis.forEach(e => {
          return e.fields = JSON.parse(e.fields)
        });
				this.apis = response.data.apis;
			})
		},
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
