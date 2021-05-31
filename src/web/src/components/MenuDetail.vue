<template>
  <div id="layout-config" :class="containerClass">
    <a href="#" class="layout-config-close" @click="hideConfigurator">
      <i class="pi pi-times"></i>
    </a>

    <div class="layout-config-content">
      <div v-if="selectedLead && Object.keys(selectedLead).length" class="selectedLead" key="selectedLead">
        <router-link class="lead-page" :to="{name: 'lead', params: {id: selectedLead.id}}">
          {{ selectedLead.summary }}
        </router-link>
        <div>
          <div class="card p-fluid">
            <Accordion>
              <AccordionTab header="Detalhes" :active="true">
                <div class="p-field">
                  <label class="p-text-bold" for="status">Condição</label>
                  <Dropdown v-model="selectedLead.status" :options="conditionValues" optionLabel="name" placeholder="Select" @change="changeStatus($event, selectedLead)" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="priority">Prioridade</label>
                  <Dropdown v-model="selectedLead.priority" :options="priorityValues" optionLabel="name" placeholder="Select" @change="changePriority($event, selectedLead)" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="assignee">Responsável</label>
                  <AutoComplete placeholder="Procurar" id="dd" :dropdown="true" :multiple="false" v-model="selectedLead.user" field="name" :suggestions="filteredUser" @complete="searchUser($event)" @item-select="changeUser($event, selectedLead)" >
                    <template #item="slotProps">
                      <div class="user-item">
                        <img class="icon" :src="slotProps.item.avatar_url" />
                        <div class="p-ml-3">{{slotProps.item.name}}</div>
                      </div>
                    </template>
                  </AutoComplete>
                </div>
              </AccordionTab>
              <AccordionTab header="Datas">
                <div class="p-field">
                  <label class="p-text-bold" for="created">Criado em:</label>
                  <InputText id="created" :disabled="true" :value="selectedLead.created_at" type="text" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="updated">Ultima alteração em:</label>
                  <InputText id="updated" :disabled="true" :value="selectedLead.updated_at" type="text" />
                </div>
              </AccordionTab>
              <AccordionTab header="Dados">
                <div class="p-field">
                  <label class="p-text-bold" for="name">Nome</label>
                  <InputText id="name" :disabled="true" :value="selectedLead.name" type="text" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="email">E-mail</label>
                  <InputText id="email" :disabled="true" :value="selectedLead.email" type="text" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="phone">Telefone</label>
                  <InputText id="phone" :disabled="true" :value="selectedLead.phone" type="text" />
                </div>
                <div class="p-field">
                  <label class="p-text-bold" for="message">Mensagem</label>
                  <Textarea :autoResize="true" rows="3" cols="30" id="message" :disabled="true" :value="selectedLead.message"/>
                </div>
              </AccordionTab>
            </Accordion>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { api } from "@/services.js";
  export default {
    props: {
      active: {
        type: Boolean,
        default: false
      },
      selectedLead: {
        type: Object,
      },
      priorityValues: {
        type: Array,
      },
      conditionValues: {
        type: Array,
      },
    },
    data() {
      return {
        d_active: this.active,
        filteredUser: [],
        usersValue: [],
      }
    },
    watch: {
      $route() {
        if (this.d_active) {
          this.d_active = false;
        }
      },
      active() {
        this.d_active = true;
      },
    },
    methods: {
      hideConfigurator(event) {
        this.d_active = false;
        event.preventDefault();
      },
      searchUser(event) {
        setTimeout(() => {
          if (!event.query.trim().length) {
            this.filteredUser = [...this.usersValue];
          }
          else {
            this.filteredUser = this.usersValue.filter((user) => {
              return user.name.toLowerCase().startsWith(event.query.toLowerCase());
            });
          }
          api.get("/users/search?username="+event.query)
          .then((response) => {
            this.usersValue = response.data;
          })
        }, 150);
      },
      changeStatus(event, lead){
        api.put("/lead/status", {lead_id: lead.id, status_id: event.value.code})
        .then((response) => {
          this.$emit('update-user', response)
        })
      },
      changePriority(event, lead){
        api.put("/lead/priority", {lead_id: lead.id, priority_id: event.value.code})
        .then((response) => {
          this.$emit('update-user', response)
        })
      },
      changeUser(event, lead){
        api.put("/lead/user", {lead_id: lead.id, user_id: event.value.id})
        .then((response) => {
          this.$emit('update-user', response)
        })
      },
    },
    computed: {
      containerClass() {
        return ['layout-config', {'layout-config-active': this.d_active}];
      },
    },
  }
</script>
<style lang="scss" scoped>
.icon {
  width: 20px;
  height: 20px;
}

.user-item {
  display: flex;
}

</style>