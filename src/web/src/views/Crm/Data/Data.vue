<template>
	<div class="p-grid crud-demo">
    <Toast position="bottom-right" />
		<div class="p-col-12">
			<div class="card">
			<h5>Dados Salvos</h5>
				<Accordion>
          <div v-for="(value, index) in data" :key="index">
            <AccordionTab>
              <template #header>
                <div class="p-d-flex p-jc-between" style="width: 100%">
                  <span>/{{pageName}}/{{ value.api }}</span>
                </div>
              </template>
              <DataTable :value="value.data" :paginator="true" :rows="5" :filters="filters1" class="p-datatable-customers" sortMode="single" :sortOrder="1">
                <template #header>
						      <div class="table-header">
                    List of Customers
                    <span class="p-input-icon-left">
                      <i class="pi pi-search" />
                      <InputText v-model="filters1['global']" placeholder="Global Search" />
                    </span>
						      </div>
					      </template>
                <Column v-for="col of columns[value.api]" :field="col.field" :header="col.header" :key="col.field"></Column>
				        <Column field="delete" header="Ação">
                  <template #body="slotProps">
                    <Button icon="pi pi-trash" class="p-button-rounded p-button-danger p-mr-2 p-mb-2" @click.prevent="confirmDeleteData(slotProps.data)" />
                  </template>
                </Column>
              </DataTable>
            </AccordionTab>
          </div>
				</Accordion>
			</div>

      <Dialog :visible.sync="deleteDataDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
        <div class="confirmation-content">
          <i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
          <span v-if="data">Tem certeza que deseja deletar o campo <b>{{ value.id }}</b>?</span>
        </div>
        <template #footer>
          <Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteDataDialog = false"/>
          <Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteData" />
        </template>
      </Dialog>
    </div>
	</div>
</template>

<script>
import { api } from "@/services.js";
import { mapGetters } from 'vuex';

export default {
	data() {
		return {
      data: [],
      filters1: {},
      errors: [],
      columns: [],
      deleteDataDialog: false,
      value: [],
      valueId: ""
    }
	},
	created() {
    this.loadData();
	},
	mounted() {
	},
	methods: {
		async loadData() {
			await api.get("/data/get-all")
			.then((response) => {
        this.data = [];
				this.data = response.data.data;
        this.columns = response.data.columns;
			})
		},
    confirmDeleteData(value) {
			this.value = value;
			this.deleteDataDialog = true;
		},
    async deleteData() {
      await api.delete(`/data/delete?id=${this.value.id}`)
			.then((response) => {
        this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Deletado com sucesso.`, life: 3000});
        this.deleteDataDialog = false;
        this.loadData();
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
/deep/ .p-datatable.p-datatable-customers {
	.p-datatable-header {
		padding: 1rem;
		text-align: left;
		font-size: 1.5rem;
	}

	.p-paginator {
		padding: 1rem;
	}

	.p-datatable-thead > tr > th {
		text-align: left;
	}

	.p-datatable-tbody > tr > td {
		cursor: auto;
	}

	.p-dropdown-label:not(.p-placeholder) {
		text-transform: uppercase;
	}
}

/* Responsive */
.p-datatable-customers .p-datatable-tbody > tr > td .p-column-title {
	display: none;
}

@media screen and (max-width: 960px) {
	/deep/ .p-datatable {
		&.p-datatable-customers {
			.p-datatable-thead > tr > th,
			.p-datatable-tfoot > tr > td {
				display: none !important;
			}

			.p-datatable-tbody > tr {
				> td {
					text-align: left;
					display: block;
					border: 0 none !important;
					width: 100% !important;
					float: left;
					clear: left;
					border: 0 none;

					.p-column-title {
						padding: .4rem;
						min-width: 30%;
						display: inline-block;
						margin: -.4rem 1rem -.4rem -.4rem;
						font-weight: bold;
					}

					.p-progressbar {
						margin-top: .5rem;
					}
				}
			}
		}
	}
}
</style>
