<template>
	<div class="p-grid crud-demo">
    <Toast position="bottom-right" />
		<div class="p-col-12">
			<div class="card">
				<h5>Customização de APIS</h5>
        <div class="p-col-12 p-mb-2 p-lg-4 p-mb-lg-0">
          <div class="p-inputgroup">
            <span class="p-inputgroup-addon">
              /{{ pageName }}/
            </span>
            <InputText v-model="newApiName" placeholder=""/>
            <Button label=" Novo" class="p-mr-2 p-mb-2 pi pi-plus" @click.prevent="newApi()"/>
          </div>
        </div>
				<Accordion>
          <div v-for="(api, index) in apis" :key="index">
            <AccordionTab>
              <template #header>
                <div class="p-d-flex p-jc-between" style="width: 100%">
                  <span>{{ api.api_full }}</span>
				          <Button icon="pi pi-trash" class="p-button-rounded p-button-danger p-mr-2 p-mb-2" @click.prevent="confirmDeleteApi(api)" />
                </div>
              </template>
              <DataTable :value="api.fields" editMode="cell" class="editable-cells-table" sortMode="single" :sortOrder="1">
                <Column field="name" header="Campo">
                  <template #editor="slotProps">
                    <InputText type="text" placeholder="Label" v-model="slotProps.data.name"></InputText>
                  </template>
                </Column>
                <Column field="type.name" header="Tipo">
                  <template #editor="slotProps">
                    <Dropdown v-model="slotProps.data.type" :options="typeValues" optionLabel="name" placeholder="Select" />
                  </template>
                </Column>
                <Column field="description" header="Descrição">
                  <template #editor="slotProps">
                    <Textarea placeholder="Your Message" v-model="slotProps.data.description" :autoResize="true" rows="3" cols="30" />
                  </template>
                </Column>
                <Column field="delete" header="Ação">
                  <template #body="slotProps">
                    <Button icon="pi pi-trash" class="p-button-rounded p-button-danger p-mr-2 p-mb-2" @click.prevent="confirmDeleteField(slotProps.data, api.id)" />
                  </template>
                </Column>
              </DataTable>
				      <Button label="" class="p-mr-2 p-mb-2 pi pi-plus" @click.prevent="newField(api.weight)"/>
            </AccordionTab>
          </div>
          <Button label=" Salvar" class="p-button-success p-mr-2 p-mb-2 pi pi-check" @click.prevent="storeApis()" />
				</Accordion>
			</div>

      <Dialog :visible.sync="deleteFieldDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
        <div class="confirmation-content">
          <i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
          <span v-if="api">Tem certeza que deseja deletar o campo <b>{{ field.name }}</b>?</span>
        </div>
        <template #footer>
          <Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteFieldDialog = false"/>
          <Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteField" />
        </template>
      </Dialog>

      <Dialog :visible.sync="deleteApiDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
        <div class="confirmation-content">
          <i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
          <span v-if="field">Tem certeza que deseja deletar a API <b>{{ api.api }}</b>?</span>
        </div>
        <template #footer>
          <Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteApiDialog = false"/>
          <Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteApi" />
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
      apis: [],
      field: [],
      fieldId: "",
      api: [],
      newApiName: "",
      deleteFieldDialog: false,
			deleteApiDialog: false,
      typeValues: [
          {name: 'Texto', code: 'string'},
					{name: 'Numérico', code: 'numeric'},
      ],
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
    newField(weight) {
      this.apis.forEach(e => {
        if (e.weight == weight){
          e.fields.push(            
            {
              "name": "",
              "type": {
                "name":"",
                "code": ""
              },
              "description": "",
            },)
        }
      });
    },
    newApi() {
      this.apis.push({
        "weight": this.apis.length >= 1 ? parseInt(this.apis.length) + 1 : 1,
        "api": `/${this.pageName}/${this.newApiName}`,
        "fields": [
          {
            "name": "",
            "type": {
              "name":"",
              "code": ""
            },
            "description": "",
          },
        ],
      })
    },
    confirmDeleteApi(api) {
			this.api = api;
			this.deleteApiDialog = true;
		},
    async deleteApi() {
      this.deleteApiDialog = false;
      try{
				await api.delete(`/api/delete-api?api_id=${this.api.id}`)
				.then(response => {
          this.apis = this.apis.filter(api => {
            return api.id !== this.api.id;
          });
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `APIs Salvas.`, life: 3000});
        })
			} catch(error) {
        this.$toast.add({severity:'error', summary: 'Ocorreu algum erro, contate o administrador', detail: `APIs Salvas.`, life: 3000});
      }
    },
    confirmDeleteField(field, id) {
			this.field = field;
      this.fieldId = id;
			this.deleteFieldDialog = true;
		},
    deleteField() {
      this.deleteFieldDialog = false;
      this.apis.forEach(api => {
        if (api.id === this.fieldId){
          api.fields = api.fields.filter(field => {
            return field.name !== this.field.name
          })
        }
      });
      this.storeApis();
    },
    async storeApis() {
      try{
				await api.post(`/api/store-api`, this.apis)
				.then(response => {
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `APIs Salvas.`, life: 3000});
        })
			} catch(error){
        this.$toast.add({severity:'error', summary: 'Ocorreu algum erro, contate o administrador', detail: `APIs Salvas.`, life: 3000});
      }
    },
    test() {
      console.log('testt');
    }
	},
  computed: {
    ...mapGetters([
      'pageName',
    ]),
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
