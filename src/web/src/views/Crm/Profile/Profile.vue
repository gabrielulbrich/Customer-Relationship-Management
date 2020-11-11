<template>
	<div>
		<div class="p-grid p-fluid dashboard">
			<div class="p-col-12 p-lg-12 contacts">
				<Panel header="Configurações da conta">
					<ul>
						<li>
							<button @click="openDialog('avatar')" class="p-link">
								<p class="label"><strong>Avatar</strong></p>
								<img :src="avatar" width="35" alt="avatar2"/>
								<span class="edit" style="margin-top: 20px;">Editar</span>
							</button>
						</li>
						<li>
							<button @click="openDialog('name')" class="p-link">
								<p class="label"><strong>Nome</strong></p>
								<span>{{ name }}</span>
								<span class="edit">Editar</span>
							</button>
						</li>
						<li>
							<button @click="openDialog('email')" class="p-link">
								<p class="label"><strong>E-mail</strong></p>
								<span>{{ email }}</span>
								<span class="edit">Editar</span>
							</button>
						</li>
						<li>
							<button @click="openDialog('password')" class="p-link">
								<p class="label"><strong>Senha</strong></p>
								<span class="edit">Editar</span>
							</button>
						</li>
					</ul>
				</Panel>
			</div>
		</div>

		<Dialog :visible.sync="editAvatarDialog" :style="{width: '450px'}" header="Editar avatar do usuário" :modal="true" class="p-fluid">
			<Button class="p-link"><img src="/assets/user_icons/boy.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/boy-1.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/girl.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/girl-1.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/man.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/man-1.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/man-2.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/man-3.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/man-4.png" width="35" alt="avatar2"/></Button>
			<Button class="p-link"><img src="/assets/user_icons/user.png" width="35" alt="avatar2"/></Button>

			<small class="p-invalid" v-if="errors.length && errors[0].avatar">{{errors[0].avatar[0]}}</small>

			<template #footer>
				<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
				<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updateUser('avatar')" />
			</template>
		</Dialog>

		<Dialog :visible.sync="editNameDialog" :style="{width: '450px'}" header="Editar nome de usuário" :modal="true" class="p-fluid">
			<div class="p-field">
				<InputText id="name" placeholder="Digite seu nome" v-model="user.name" required="true" autofocus :class="{'p-invalid': submitted && !user.name}" />
				<small class="p-invalid" v-if="errors.length && errors[0].name">{{errors[0].name[0]}}</small>
			</div>
			
			<template #footer>
				<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
				<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updateUser('name')" />
			</template>
		</Dialog>

		<Dialog :visible.sync="editEmailDialog" :style="{width: '450px'}" header="Editar e-mail" :modal="true" class="p-fluid">
			<div class="p-field">
				<InputText id="email" placeholder="Digite um novo e-mail" v-model.trim="user.email" required="true" autofocus :class="{'p-invalid': submitted && !user.email}" />
				<small class="p-invalid" v-if="errors.length && errors[0].email">{{errors[0].email[0]}}</small>
			</div>
			
			<template #footer>
				<Button label="Cancel"  icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
				<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updateUser('email')" />
			</template>
		</Dialog>

		<Dialog :visible.sync="editPasswordDialog" :style="{width: '450px'}" header="Editar senha" :modal="true" class="p-fluid">
			<div class="p-field">
				<InputText id="current_password" type="password" placeholder="Senha atual" v-model="user.password.current_password" required="true" autofocus :class="{'p-invalid': errors.length && errors[0].current_password}" />
				<small class="p-invalid" v-if="errors.length && errors[0].current_password">{{errors[0].current_password[0]}}</small>
			</div>
			<div class="p-field">
				<InputText id="password" type="password" placeholder="Nova senha" v-model="user.password.password" required="true" autofocus :class="{'p-invalid': errors.length && errors[0].password}" />
			</div>
			<div class="p-field">
				<InputText id="password_confirm" type="password" placeholder="Confirme a senha" v-model="user.password.password_confirmation" required="true" autofocus :class="{'p-invalid': errors.length && errors[0].password}" />
				<small class="p-invalid" v-if="errors.length && errors[0].password">{{errors[0].password[0]}}</small>
				
			</div>
			
			<template #footer>
				<Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog"/>
				<Button label="Save" icon="pi pi-check" class="p-button-text" @click="updateUser('password')" />
			</template>
		</Dialog>
	</div>
</template>

<script>
export default {
	components: {

    },
	data(){
		return{
			lead: {},
			user: {
				avatar: "",
				name: "",
				email: "",
				password: {
					current_password: null,
					password: null,
					password_confirmation: null,
				}
			},
			errors: [],
			submitted: false,
			editAvatarDialog: false,
			editNameDialog: false,
			editEmailDialog: false,
			editPasswordDialog: false,
		}
	},
	watch: {

	},
    methods: {
		openDialog(dialog){
			switch (dialog) {
				case 'avatar':
					this.submitted = false;
					this.editAvatarDialog = true;
					break;
				case 'name':
					this.submitted = false;
					this.editNameDialog = true;
					break;
				case 'email':
					this.submitted = false;
					this.editEmailDialog = true;
					break;
				case 'password':
					this.submitted = false;
					this.editPasswordDialog = true;
					break;
			}
		},
		hideDialog() {
			this.editNameDialog = false;
			this.editEmailDialog = false;
			this.editPasswordDialog = false;
			this.submitted = false;
		},
		updateUser(dialog){
			this.submitted = true
			switch (dialog) {
				case 'avatar':
					this.update({ avatar_url: this.user.avatar })
					break;
				case 'name':
					this.update({name: this.user.name })
					break;
				case 'email':
					this.update({ email: this.user.email })
					break;
				case 'password':
					this.update({ current_password: this.user.password.current_password,
								password: this.user.password.password,
								password_confirmation: this.user.password.password_confirmation })
					break;
			}
		},
		async update(payload){
			this.errors = [];
			try{
				await this.$store.dispatch("updateUser", payload);
				await this.hideDialog();
			} catch(error){
				this.errors.push(error.response.data)
			}
		}
	},
	computed: {
		name(){
			return this.$store.state.user.name;
		},
		email(){
			return this.$store.state.user.email;
		},
		avatar(){
			return this.$store.state.user.avatar;
		},
	},
}
</script>

<style lang="scss" scoped>

	.label{
		width: 190px;
		display: inline-block
	}

	.dashboard{
		.contacts{
			ul {
				li{
					button{
						padding: 15px 9px 0px 9px;
					}
				}
			}
		}
	}

	.p-dialog-content{
		.p-link{
			display: inline-block !important;
			width: auto !important;
			margin: 5px 5px !important;
		}
	}
	

	.edit{
		// position: absolute;
		float: right;
		color: #007be5;
		// right: 10px;
	}
</style>
