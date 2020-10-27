<template>
	<div>
		<div class="messages" style="margin-top: 25px;">
			<div class="messages-image">
				<img src="https://issues.redhat.com/secure/projectavatar?pid=12318028&avatarId=25966" alt="Logo">
			</div>
			<div class="messages-card" style="">
				<div class="p-col">
					<div class="messages-name">
						<p><span>Gabriel Ulbrich</span> • 10 Out 2020</p>
					</div>
					<div class="messages-text">
						<span>Esta e uma mensagem</span>
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
			history: {
				type: Object,
			},
		},
		data() {
			return {

			}
		},
		watch: {

		},
		methods: {
			
		},
		computed: {

		},
	}
</script>

<style lang="scss" scoped>
	.messages {
		&-image{
			display: inline-block;
			img{
				height: 35px;
				width: 35px;
				display: block;
			}
		}
		&-name{
			
			span{
				font-weight: 600;
			}
		}
		&-card{
			background-color: #ffffff;
			padding: 0.2em 1em 0.2em 1em;
			margin-bottom: 16px;
			border-radius: 3px;
			position: absolute;
			display: inline-block;
			margin-left: 10px;
		}
	}
</style>