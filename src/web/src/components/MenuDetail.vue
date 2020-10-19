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
									<InputText id="status" :disabled="true" :value="selectedLead.status.status" type="text" />
								</div>
								<div class="p-field">
									<label class="p-text-bold" for="priority">Prioridade</label>
									<InputText id="priority" :disabled="true" :value="selectedLead.priority.priority" type="text" />
								</div>
								<div class="p-field">
									<label class="p-text-bold" for="assignee">Responsável</label>
									<AutoComplete placeholder="Procurar" id="dd" :dropdown="true" :multiple="false" v-model="selectedUser" :suggestions="filteredUser" @complete="searchUser($event)" field="name"/>
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
					<p>{{ selectedLead.telefone }}</p>
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
			}
		},
		data() {
			return {
				d_active: this.active,
				filteredUser: [],
				selectedUser: [],
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
			selectedLead(){
				console.log(this.selectedLead);
			}
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
					console.log(this.usersValue, this.filteredUser)
					api.get("/users/search?username="+event.query)
					.then((response) => {
						this.usersValue = response.data;
					})
				}, 250);
			}
		},
		computed: {
			containerClass() {
				return ['layout-config', {'layout-config-active': this.d_active}];
			},
		},
	}
</script>
