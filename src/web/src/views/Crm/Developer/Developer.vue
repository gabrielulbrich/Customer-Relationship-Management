<template>
	<div class="p-grid crud-demo">
		<div class="p-col-12">
			<div class="card">
				<h5>Customização de APIS</h5>
				<Accordion>
          <div v-for="(api, index) in apis" :key="index">
            <AccordionTab :header="api.api">
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
              </DataTable>
				      <Button label="Salvar" class="p-mr-2 p-mb-2"/>
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
      apis: [
        {
          "id":1,
          "api":"\/site\/form",
          "fields": [
            {
              "name": "Test",
              "type": {
                "name":"Texto",
                "code": "text"
              },
              "description": "Descrição sobre o campo.",
            },
            {
              "name": "Test2",
              "type": {
                "name":"Numérico",
                "code": "numeric"
              },
              "description": "Descrição sobre o campo 2.",
            },
          ],
          "pivot": {
            "page_id":1,
            "api_id":1
          }
        },
        {
          "id":2,
          "api":"\/test\/qualquer",
          "fields": [
            {
              "name": "Test",
              "type": {
                "name":"Texto",
                "code": "text"
              },
              "description": "Descrição sobre o campo.",
            },
          ],
          "pivot":{ 
            "page_id":1,
            "api_id":2
            }
          }
      ],
      typeValues: [
          {name: 'Texto', code: 'text'},
					{name: 'Numérico', code: 'numeric'},
      ],
      editingRows: [],
			errors: [],
		}
	},
	created() {
    // this.loadApis();
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
    onRowEditInit(event) {
      return 'ok';
      // this.originalRows[event.index] = {...this.products3[event.index]};
    },
    onRowEditCancel(event) {
      return 'bah';
      // this.products3[event.index] = this.originalRows[event.index];
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
