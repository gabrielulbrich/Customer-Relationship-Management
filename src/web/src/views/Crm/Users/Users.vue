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

				<DataTable ref="dt" :value="users" dataKey="id" :paginator="true" :rows="10" :filters="filters"
                            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} users">
					<template #header>
						<div class="table-header">
							<h5 class="p-m-0">Manage Users</h5>
							<span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global']" placeholder="Search..." />
                            </span>
						</div>
					</template>

					<Column headerStyle="width: 8rem">
						<template #body="slotProps">
							<img :src="slotProps.data.avatar" alt="Avatar" class="product-image" />
						</template>
					</Column>
					<Column field="name" header="Nome" sortable></Column>
					<Column field="email" header="Email" sortable></Column>
					
					<Column>
						<template #body="slotProps">
							<Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-mr-2" @click="openEdit(slotProps.data)" />
							<Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="confirmDeleteUser(slotProps.data)" />
						</template>
					</Column>
				</DataTable>

				<Dialog :visible.sync="newUserDialog" :style="{width: '450px'}" header="Adicionar Usuário" :modal="true" class="p-fluid">
					<div class="p-field">
                        <InputText id="name" placeholder="nome" type="text" :class="{'p-invalid': errors.length && errors[0].name}" aria-describedby="name-help" v-model="user.name" />
                        <small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
                    </div>
                    <div class="p-field">
                        <InputText id="cpf" placeholder="cpf" type="text"  :class="{'p-invalid': errors.length && errors[0].cpf}" aria-describedby="cpf-help" v-model="user.cpf"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].cpf">{{errors[0].cpf[0]}}</small>
                    </div>
                    <p>Informações de acesso:</p>
                    <div class="p-field">
                        <InputText id="email" placeholder="email" type="email"  :class="{'p-invalid': errors.length && errors[0].email}" aria-describedby="email-help" v-model="user.email"/>
                        <small class="p-invalid" v-if="errors.length && errors[0].email">{{errors[0].email[0]}}</small>
                    </div>
					<div class="p-field">
						<Dropdown v-model="user.profile" :options="profiles" optionLabel="name" placeholder="Perfil do usuário" :class="{'p-invalid': errors.length && errors[0].profile}" />
                        <small class="p-invalid" v-if="errors.length && errors[0].profile">{{errors[0].profile[0]}}</small>
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
						<Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveUser" />
					</template>
				</Dialog>

				<Dialog :visible.sync="editUserDialog" :style="{width: '450px'}" header="Editar Usuário" :modal="true" class="p-fluid">
					<div class="p-field">
						<label for="profiles">Selecione o perfil</label>
						<Dropdown id="profiles" v-model="user.profile" :options="profiles" optionLabel="name" placeholder="Perfil do usuário" :class="{'p-invalid': errors.length && errors[0].profile}" style="margin-bottom: 60px;" />
                        <small class="p-invalid" v-if="errors.length && errors[0].profile">{{errors[0].profile[0]}}</small>
                    </div>
					<template #footer>
						<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
						<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updateUser" />
					</template>
				</Dialog>

				<Dialog :visible.sync="deleteUserDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
					<div class="confirmation-content">
						<i class="pi pi-exclamation-triangle p-mr-3" style="font-size: 2rem" />
						<span v-if="product">Are you sure you want to delete <b>{{product.name}}</b>?</span>
					</div>
					<template #footer>
						<Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteUserDialog = false"/>
						<Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteUser" />
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
			newUserDialog: false,
			editUserDialog: false,
			deleteUserDialog: false,
			product: {},
			filters: {},
			submitted: false,

			errors: [],
			user: {},
			users: [],
			profiles: [],

		}
	},
	productService: null,
	created() {
		this.loadUsers();
	},
	mounted() {
		// this.productService.getUsers().then(data => this.products = data);
	},
	methods: {
		loadUsers(){
			api.get("/users")
			.then((response) => {
				this.users = response.data.users;
				this.profiles = response.data.profiles;
			})
		},
		formatCurrency(value) {
			return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
		},
		openNew() {
			this.product = {};
			this.submitted = false;
			this.newUserDialog = true;
		},
		openEdit(user) {
			this.user = {...user};
			this.editUserDialog = true;
		},
		hideDialog() {
			this.newUserDialog = false;
			this.editUserDialog = false;
			this.submitted = false;
			this.deleteUserDialog = false;
			this.user = {};
		},
		async saveUser(){
			this.errors = [];
			try{
				await api.post(`/user/register`, this.user)
				.then(response => {
					this.users.push(response.data);
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} criado.`, life: 3000});
				})
				await this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		},
		async updateUser(){
			this.errors = [];
			try{
				await api.put(`/user/update-profile`, {profile_id: this.user.profile.code, user_id: this.user.id })
				.then((response) => {
					if (this.user.id) {
						this.$set(this.users, this.findIndexById(this.user.id), this.user);
					}
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} alterado.`, life: 3000});
				})
				await this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		},
		confirmDeleteUser(user) {
			this.user = user;
			this.deleteUserDialog = true;
		},
		deleteUser() {
			try{
				api.delete(`/user/delete?user_id=${this.user.id}`)
				.then(response => {
					this.users = this.users.filter(val => val.id !== response.data.id);
					this.$toast.add({severity:'success', summary: 'Sucesso', detail: `Usuário ${response.data.name} excluído.`, life: 3000});
				})
				this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}

		},
		findIndexById(id) {
			let index = -1;
			for (let i = 0; i < this.users.length; i++) {
				if (this.users[i].id === id) {
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
