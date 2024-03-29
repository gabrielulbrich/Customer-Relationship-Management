<template>
  <div>
    <div class="p-grid">
      <div class="p-col-12">
        <div class="header">
          <div class="header-main">
              <Inplace :closable="true" @close="submitSummary">
                <template #display>
                    <span>{{lead.summary}} #{{$route.params.id}}</span>
                </template>
                <template #content>
                    <InputText v-model="lead.summary" autoFocus />
                </template>
            </Inplace>
          </div>
        </div>
      </div>
    </div>

    <div class="p-grid nested-grid">
      <div class="p-col">
        <div class="p-grid">
          <div class="p-col-12 details">
            <div>
              <Dropdown v-model="lead.status" :options="conditionValues" optionLabel="name" placeholder="Condição" @change="changeStatus($event, lead)" />
              <Dropdown v-model="lead.priority" :options="priorityValues" optionLabel="name" placeholder="Prioridade" @change="changePriority($event, lead)" />
              <AutoComplete v-model="newUser" placeholder="Atribuir à" id="dd" :dropdown="true" :multiple="false" field="name" :suggestions="filteredUser" @complete="searchUser($event)" @item-select="changeUser($event, lead)" >
                <template #item="slotProps">
                  <div class="user-item">
                    <img class="icon" :src="slotProps.item.avatar_url" />
                    <div class="p-ml-3">{{slotProps.item.name}}</div>
                  </div>
                </template>
              </AutoComplete>
            </div>
            <ul v-if="Object.keys(this.lead).length > 0" class="details-two-cols">
              <li class="details-item right">
                <span class="name">Prioridade:</span>
                <span class="value">
                  <img :src=lead.priority_icon alt="Icon Image">
                  {{ lead.priority.name }}
                </span>
              </li>
              <li class="details-item">
                <span class="name">Condição:</span>
                <span class="value p-tag p-tag-rounded p-tag-info">{{ lead.status.name }}</span>
              </li>
              <li class="details-item right">
                <span class="name">Atribuído à:</span>
                <span class="value">
                  <img :src="lead.avatar_url" alt="Icon Image">
                  {{ lead.user.name }}
                </span>
              </li>
              <li class="details-item">
                <span class="name">Data de criação:</span>
                <span class="value">19 Out 2020</span>
              </li>
              <li class="details-item">
                <span class="name">Última alteração:</span>
                <span class="value">24 Out 2020</span>
              </li>
            </ul>
          </div>
          <div class="p-col-12 comment">
            <div>
              <label for="note">Observação Interna</label>
              <Textarea id="note" v-model="comment" placeholder="Your Message" :autoResize="true" rows="3" cols="30" />
              <Button label="Comentar" @click="submitComment" class="p-mr-2 p-mb-2" style="float:right"></Button>
            </div>
          </div>
          <div class="p-col-12 comment">
            <Comment :comments="lead.comments" />
          </div>
          
        </div>
      </div>
      <div class="p-col-4" style="min-width: 350px">
        <Carousel v-if="anotherLeads && anotherLeads.length" :value="anotherLeads" :numVisible="1" :numScroll="1" :circular="true" style="background: #FFF;">
          <template #header>
            <h2 class="title">RELACIONADOS</h2>
          </template>
          <template #item="slotProps">
            <div class="car-item">
              <div class="car-content">
                <div>
                  <router-link class="lead-page" :to="{name: 'lead', params: {id: slotProps.data.id}}">
                    <span>{{slotProps.data.summary}}</span>
                  </router-link>
                  <div class="p-d-flex p-jc-between value" style="margin-top: 10px">
                    <div :class="{
                      'p-tag p-tag-rounded p-tag-info': slotProps.data.status.code != 4,
                      'p-tag p-tag-rounded p-tag-success': slotProps.data.status.code == 4,
                    }">
                      {{slotProps.data.status.name}}
                    </div>
                    <img :src=slotProps.data.priority_icon alt="Icon Image Prioridade">
                    <div>
                      <img :src="slotProps.data.user.avatar" alt="Icon Image Avatar">
                      {{ lead.user.name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </Carousel>
        <div class="card p-mt-4">
          <h2 class="title">Dados</h2>
          <div v-for="(column, index) in lead.columns" :key="index">
            <strong><p class="p-mb-0">{{column.field}}</p></strong>
            <Textarea class="p-col-12 p-mb-3" type="text" rows="2" :placeholder="lead.data[column.field]" :disabled="true"></Textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { api } from "@/services.js";
import Comment from '@/components/Comment.vue';

export default {
  components: {
      Comment
  },
  data(){
    return{
      lead: {},
      anotherLeads: [],
      priorityValues: [],
      conditionValues: [],
      filteredUser: [],
      usersValue: [],
      errors: [],
      comment: null,
      newSummary: "",
      newUser: "",
    }
  },
  watch: {
    $route() {
      this.loadLead();
    },
  },
  methods: {
    loadLead() {
      this.errors = [];
      api.get(`/lead/${this.$route.params.id}`)
      .then((response) => {
        this.lead = response.data.lead;
        this.anotherLeads = response.data.another_leads
        this.priorityValues = response.data.priorities;
        this.conditionValues = response.data.status;
      })
      .catch(error => {
        console.log('error', error)
        this.errors.push(error.response);
      });
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
        this.lead = Object.assign(this.lead, response.data);
      })
    },
    changePriority(event, lead){
      api.put("/lead/priority", {lead_id: lead.id, priority_id: event.value.code})
      .then((response) => {
        this.lead = Object.assign(this.lead, response.data);
      })
    },
    changeUser(event, lead){
      api.put("/lead/user", {lead_id: lead.id, user_id: event.value.id})
      .then((response) => {
        this.lead = Object.assign(this.lead, response.data);
      })
    },
    submitComment(){
      api.post("/lead/comment", {lead_id: this.lead.id, user_id: this.$store.state.user.id, comment: this.comment})
      .then((response) => {
        this.lead.comments.unshift(response.data);
      })
    },
    submitSummary() {
      api.post("/lead/summary", {lead_id: this.lead.id, summary: this.lead.summary})
      .then((response) => {
        console.log(response);
      })
    }
  },
  created(){
    this.loadLead();
  },
}
</script>

<style lang="scss" scoped>
.header {
  &-image{
    display: inline-block;
    img{
      height: 48px;
      width: 48px;
      display: block;
    }
  }
  &-main{
    display: inline-block;
    &__title{
      font-weight: 600;
      font-size: 18px;
      margin-top: 7px;
    }
  }
}

.value{
  img{
    width: 15px;
    height: 15px;
  }
}

.title {
  text-align: center;
  font-weight: 600;
    font-size: 18px;
    margin: 5px 0px 20px 0px;
    text-transform: uppercase;
}

.details{
  // margin-top: 10px;
  .p-dropdown{
    margin: 15px 5px 10px 0px;
  }
  &-two-cols{
    display: block;
    margin: 0;
    list-style: none;
    padding: 0;
  }
  &-item{
    box-sizing: border-box;
    clear: left;
    float: left;
    width: 50%;
    list-style: none;
    padding: 0;
    margin: 0;
    position: relative;

    .name{
      color: #787575;
      width: 50%;
      float: left;
    }
  }
  .right{
    clear: right;
    float: right;
  }
}

.comment{
  margin-top: 25px;
  .p-inputtextarea{
    width: 100%;
  }
}

.p-inplace {
  font-weight: 500;
  font-size: 22px;
}
 
.user-item {
  display: flex;
}

.icon {
  width: 20px;
  height: 20px;
}
</style>
