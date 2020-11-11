<template>
	<div>
		<div class="p-grid">
			<div class="p-col-12">
				<div class="header">
					<div class="header-image">
						<img :src="$store.state.page.logo_url" alt="Logo">
					</div>
					<div class="header-main">
						<span>{{ $store.state.page.name }} / {{ $route.params.id }}</span>
						<h1 class="header-main__title">{{ this.lead.summary }}</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="p-grid nested-grid">
			<div class="p-col-8">
				<div class="p-grid">
					<div class="p-col-12 details">
						<div>
							<Dropdown v-model="lead.status" :options="conditionValues" optionLabel="name" placeholder="Condição" @change="changeStatus($event, lead)" />
							<Dropdown v-model="lead.priority" :options="priorityValues" optionLabel="name" placeholder="Prioridade" @change="changePriority($event, lead)" />
							<AutoComplete v-model="lead.user" placeholder="Atribuir à" id="dd" :dropdown="true" :multiple="false" field="name" :suggestions="filteredUser" @complete="searchUser($event)" @item-select="changeUser($event, lead)" />
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
					<div class="p-col-12 history">
						<History :histories="lead.histories" />
					</div>
					
				</div>
			</div>
			<div class="p-col-4" style=" height: 1000px; background: beige; display: none">
				<p>KEYWORDS DO lead</p>
				<p>OUTROS LEADS DA PESSOA COM ESSE EMAIL</p>
			</div>	
		</div>
	</div>
</template>

<script>
import { api } from "@/services.js";
import History from '@/components/History.vue';

export default {
	components: {
		History
    },
	data(){
		return{
			lead: {},
			priorityValues: [],
			conditionValues: [],
			filteredUser: [],
			usersValue: [],
			errors: [],
			comment: null,
		}
	},
	watch: {

	},
    methods: {
		loadLead() {
			this.errors = [];
			api.get(`/lead/${this.$route.params.id}`)
			.then((response) => {
				this.lead = response.data.lead;
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
				this.lead.histories.unshift(response.data);
				console.log(this.lead.histories);
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
		position: absolute;
		display: inline-block;
		&__title{
			font-weight: 600;
			font-size: 18px;
			margin-top: 7px;
			text-transform: uppercase;
		}
	}
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
		img{
			width: 15px;
			height: 15px;
		}

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
</style>
