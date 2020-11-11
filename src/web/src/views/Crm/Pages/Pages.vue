<template>
	<div class="p-grid crud-demo">
		<div class="p-col-12">
			<div class="card">
				<Toast/>
				<Toolbar class="p-mb-4">
					<template slot="left">
						<Button label="New" icon="pi pi-plus" class="p-button-success p-mr-2" @click="openNew" />
					</template>
				</Toolbar>

				<DataTable ref="dt" :value="pages" dataKey="id" :paginator="true" :rows="10" :filters="filters"
                            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} pages">
					<template #header>
						<div class="table-header">
							<h5 class="p-m-0">Manage Pages</h5>
							<span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global']" placeholder="Search..." />
                            </span>
						</div>
					</template>

					<Column field="name" header="Nome da página" sortable></Column>
					<Column field="site" header="Site" sortable></Column>
					<Column field="epic" header="EPIC" sortable></Column>
					
					<Column>
						<template #body="slotProps">
							<Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-mr-2" @click="openEdit(slotProps.data)" />
							<Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="confirmDeletePage(slotProps.data)" />
						</template>
					</Column>
				</DataTable>

				<Dialog :visible.sync="newPageDialog" :style="{width: '450px'}" header="Afodasess porrar Página" :modal="true" class="p-fluid">
					<div class="p-field">
                        <InputText id="name" placeholder="nome" type="text" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="name-help" v-model="page.name" />
                        <small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="site" placeholder="site" type="text"  :class="{'p-invalid': errors.length && errors[0].site}" aria-describedby="site-help" v-model="page.site"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].site">{{errors[0].site[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="epic" placeholder="epic" type="epic"  :class="{'p-invalid': errors.length && errors[0].epic}" aria-describedby="epic-help" v-model="page.epic"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].epic">{{errors[0].epic[0]}}</small>
                    </div>
					<div class="p-field">
                        <InputText id="token" placeholder="token" type="token"  :class="{'p-invalid': errors.length && errors[0].token}" aria-describedby="token-help" v-model="page.token"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].token">{{errors[0].token[0]}}</small>
                    </div>
					<div class="p-field">
                        <InputText id="refer" placeholder="refer" type="refer"  :class="{'p-invalid': errors.length && errors[0].refer}" aria-describedby="refer-help" v-model="page.refer"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].refer">{{errors[0].refer[0]}}</small>
                    </div>
					<p>Informações de acesso:</p>
					<div class="p-field">
                        <InputText id="name" placeholder="nome" type="text" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="name-help" v-model="user.name" />
                        <small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="cpf" placeholder="cpf" type="text"  :class="{'p-invalid': errors.length && errors[0].cpf}" aria-describedby="cpf-help" v-model="user.cpf"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].cpf">{{errors[0].cpf[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="email" placeholder="email" type="email"  :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="email-help" v-model="user.email"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].email">{{errors[0].email[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="password" placeholder="senha" type="password" :class="{'p-invalid': errors.length && errors[0].password}" aria-describedby="password-help" v-model="user.password"/>
                    </div>
                    <div class="p-field">
                        <InputText id="password_confirmation" placeholder="confirme sua senha" type="password"  :class="{'p-invalid': errors.length && errors[0].password}" aria-describedby="password_confirmation-help" v-model="user.password_confirmation"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].password">{{errors[0].password[0]}}</small>
                    </div>
					<template #footer>
						<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
						<Button label="Save" icon="pi pi-check" class="p-button-text" @click="savePage" />
					</template>
				</Dialog>

				<Dialog :visible.sync="editPageDialog" :style="{width: '450px'}" header="Editar Usuário" :modal="true" class="p-fluid">
					<div class="p-field">
                        <InputText id="name" placeholder="Nome" type="text" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="name-help" v-model="page.name" />
                        <small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
                    </div>
					<div class="p-field">
                        <InputText id="site" placeholder="Site" type="text" :class="{'p-invalid': errors.length && errors[0].site}" aria-describedby="site-help" v-model="page.site" />
                        <small class="p-invalid" v-if="errors.length && errors[0].site">{{errors[0].site[0]}}</small>
                    </div>
					<div class="p-field">
                        <InputText id="epic" placeholder="Epic" type="text" :class="{'p-invalid': errors.length && errors[0].epic}" aria-describedby="epic-help" v-model="page.epic" />
                        <small class="p-invalid" v-if="errors.length && errors[0].epic">{{errors[0].epic[0]}}</small>
                    </div>
					<template #footer>
						<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
						<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updatePage" />
					</template>
				</Dialog>

				<Dialog :visible.sync="deletePageDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
					<div class="confirmation-content">
						<i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
						<span v-if="page">Are you sure you want to delete <b>{{page.name}}</b>?</span>
					</div>
					<template #footer>
						<Button label="No" icon="pi pi-times" class="p-button-text" @click="deletePageDialog = false"/>
						<Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deletePage" />
					</template>
				</Dialog>
			</div>
		</div>
	</div>

</template>

<script>
import { api } from "@/services.js";

export default {
	data() {
		return {
			newPageDialog: false,
			editPageDialog: false,
			deletePageDialog: false,
			filters: {},
			submitted: false,

			filteredPage: [],
			usersValue: [],
			page: {},
			user: {},
			pages: [],
			errors: [],
		}
	},
	productService: null,
	created() {
		this.loadPages();
	},
	methods: {
		loadPages(){
			api.get("/pages")
			.then((response) => {
				this.pages = response.data;
			})
		},
		searchPage(event) {
			setTimeout(() => {
				if (!event.query.trim().length) {
					this.filteredPage = [...this.usersValue];
				}
				else {
					this.filteredPage = this.usersValue.filter((user) => {
						return user.name.toLowerCase().startsWith(event.query.toLowerCase());
					});
				}
				api.get("/users/search?username="+event.query)
				.then((response) => {
					this.usersValue = response.data;
				})
			}, 150);
		},
		openNew() {
			this.page = {};
			this.submitted = false;
			this.newPageDialog = true;
		},
		openEdit(page) {
			this.page = {...page};
			this.editPageDialog = true;
		},
		hideDialog() {
			this.newPageDialog = false;
			this.editPageDialog = false;
			this.submitted = false;
			this.deletePageDialog = false;
			this.page = {};
		},
		async savePage(){
			console.log(this.page)
			this.errors = [];
			try{
				await api.post(`/page/create`, {'page': this.page, 'user': this.user })
				.then(response => {
					this.pages.push(response.data.page)
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Página ${response.data.page.name} criada.`, life: 3000});
				})
				await this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		},
		async updatePage(){
			this.errors = [];
			try{
				await api.put(`/page/update`, {'page': this.page })
				.then((response) => {
					if (this.page.id) {
						this.$set(this.pages, this.findIndexById(this.page.id), this.page);
					}
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Página ${response.data.name} alterada.`, life: 3000});
				})
				await this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		},
		confirmDeletePage(page) {
			this.page = page;
			this.deletePageDialog = true;
		},
		deletePage() {
			try{
				api.delete(`/page/delete?id=${this.page.id}`)
				.then(response => {
					this.pages = this.pages.filter(val => val.id !== response.data.id);
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Página ${response.data.name} excluída.`, life: 3000});
				})
				this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		},
		findIndexById(id) {
			let index = -1;
			for (let i = 0; i < this.pages.length; i++) {
				if (this.pages[i].id === id) {
					index = i;
					break;
				}
			}

			return index;
		},
		createId() {
			let id = '';
			var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			for ( var i = 0; i < 5; i++ ) {
				id += chars.charAt(Math.floor(Math.random() * chars.length));
			}
			return id;
		},
	}
}
</script>

<style scoped lang="scss">
.table-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.product-image {
	height: 45px;
    width: 45px;
}

.p-dialog .product-image {
	width: 150px;
	margin: 0 auto 2rem auto;
	display: block;
}

.confirmation-content {
	display: flex;
	align-items: center;
	justify-content: center;
}

.product-badge {
	border-radius: 2px;
	padding: .25em .5rem;
	text-transform: uppercase;
	font-weight: 700;
	font-size: 12px;
	letter-spacing: .3px;

	&.status-instock {
		background: #C8E6C9;
		color: #256029;
	}

	&.status-outofstock {
		background: #FFCDD2;
		color: #C63737;
	}

	&.status-lowstock {
		background: #FEEDAF;
		color: #8A5340;
	}
}
</style>
