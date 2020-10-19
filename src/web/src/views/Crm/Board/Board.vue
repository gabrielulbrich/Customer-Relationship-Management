<template>
	<div>
		<div class="p-grid headers">
			<div class="p-col">
				<div class="box">ABERTO</div>
			</div>
			<div class="p-col">
				<div class="box">EM PROGRESSO</div>
			</div>
			<div class="p-col">
				<div class="box">BLOQUEADO</div>
			</div>
			<div class="p-col">
				<div class="box">FINALIZADO</div>
			</div>
		</div>
		<div class="p-grid">
			<div class="p-col">
				<div class="swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status_id == 1">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="p-col">
				<div class="swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status_id == 2">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="p-col">
				<div class="swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status_id == 3">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="p-col">
				<div class="swimlane">
					<div v-if="leads && leads.length" class="leads" key="leads">
						<div class="lead" v-for="(lead, index) in leads" :key="index">
							<div v-if="lead.status_id == 4">
								<CardLead :lead="lead" @click.native="toggleMenuDetail(lead)"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<MenuDetail :selectedLead="selectedLead" :active="active"/>

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
			leads: null
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
			})
			.catch(error => {
				console.log('error', error)
				this.errors.push(error.response);
			});
		},		
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
}
.swimlane {
	background-color: #ffffff;
	text-align: center;
	padding-top: 0.5rem;
	padding-bottom: 1rem;
	border-radius: 4px;
	min-height: 100vh;
}	
</style>
