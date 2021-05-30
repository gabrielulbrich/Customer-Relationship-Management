<template>
	<div>
		<div class="p-grid headers">
			<div class="p-col header">
				<div class="box">ABERTO</div>
			</div>
			<div class="p-col header">
				<div class="box">EM PROGRESSO</div>
			</div>
			<div class="p-col header">
				<div class="box">BLOQUEADO</div>
			</div>
			<div class="p-col header">
				<div class="box">FINALIZADO</div>
			</div>
		</div>
		<div class="p-grid swimlanes">
			<div class="p-col swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status.code == 1">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
			</div>
			<div class="p-col swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status.code == 2">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
			</div>
			<div class="p-col swimlane">
        <div v-if="leads && leads.length" class="leads" key="leads">
          <div class="lead" v-for="(lead, index) in leads" :key="index">
            <div v-if="lead.status.code == 3">
              <CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
            </div>
          </div>
				</div>
			</div>
			<div class="p-col swimlane">
        <div v-if="leads && leads.length" class="leads" key="leads">
          <div class="lead" v-for="(lead, index) in leads" :key="index">
            <div v-if="lead.status.code == 4">
              <CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
            </div>
          </div>
        </div>
			</div>
		</div>

		<MenuDetail :conditionValues="conditionValues" :priorityValues="priorityValues" @update-user="updateUser" :selectedLead="selectedLead" :active="active"/>

	</div>
</template>

<script>
import MenuDetail from '@/components/MenuDetail.vue';
import CardLead from '@/components/CardLead.vue';
import { api } from "@/services.js";

export default {
	components: {
		MenuDetail,
		CardLead,
    },
	data(){
		return{
			active: false,
			selectedLead: null,
			errors: [],
			leads: null,
			priorityValues: [],
			conditionValues: []
		}
	},
    methods: {
        toggleMenuDetail(lead) {
			this.active = !this.active;
			this.selectedLead = lead;
		},
		loadCards(){
			this.leads = null;
			this.errors = [];
			api.get("/leads")
			.then((response) => {
				this.leads = response.data.leads;
				this.priorityValues = response.data.priorities;
				this.conditionValues = response.data.status;
			})
			.catch(error => {
				console.log('error', error)
				this.errors.push(error.response);
			});
		},
		updateUser(payload){
			for (let lead of this.leads) {
				if (payload.data.id == lead.id){
					lead = Object.assign(lead, payload.data);
				}
			}
		}
	},
	created(){
		this.loadCards();
	},
}
</script>

<style lang="scss" scoped>
.headers {
	.box {
		padding: 5px 0px 10px 0px;
		border-bottom: 5px solid #fff;
		border-radius: 4px;
		font-weight: 600;
	}

  .header {
	  min-width: 187px;
    margin: 0.5rem 0.5rem 1rem 0.5rem;
  }
}

.swimlanes {
  .swimlane {
    background-color: #ffffff;
    text-align: center;
    border-radius: 4px;
    min-width: 187px;
    margin: 0.5rem 0.5rem 1rem 0.5rem;
    padding: 0;
  }
}

.headers,
.swimlanes {
  flex-wrap: nowrap;
}

.layout-main {
	overflow: scroll;
}
</style>
