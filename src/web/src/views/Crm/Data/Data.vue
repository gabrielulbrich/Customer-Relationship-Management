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
      data: [],
      filters1: {},
      errors: [],
      columns: [
        // {
        //   field: 'data.abc', 
        //   header: 'Code'
        // },
        // {field: 'data.abcd', header: 'Name'},
        // {field: 'data.abcde', header: 'Category'},
      ]
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
				this.data = response.data.data;
        this.columns = response.data.columns;
        console.log(this.data)
        console.log(this.columns);
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
