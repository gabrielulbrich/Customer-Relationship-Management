<template>
	<div v-if="comments && comments.length">
		<div v-for="(history, index) in comments" :key="index" class="messages">
			<div class="messages-image">
				<img :src="history.avatar_url" alt="Logo">
			</div>
			<div class="messages-card" style="">
				<div>
					<div class="messages-name">
						<p><span>{{ history.user.name }}</span> • {{ history.created }}</p>
					</div>
					<div class="messages-text">
						<span>{{ history.comment }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			comments: {
				type: Array,
			},
		},
		data() {
			return {

			}
		},
	}
</script>

<style lang="scss" scoped>
	.messages {
		&-image{
			img{
				height: 35px;
				width: 35px;
				display: block;
				position: absolute;
			}
		}
		&-name{
			
			span{
				font-weight: 600;
			}
		}
		&-card{
			background-color: #ffffff;
			padding: 10px 10px 10px 15px;
			margin-bottom: 16px;
			border-radius: 3px;
			position: relative;
			display: inline-block;
			margin-left: 40px;
		}
	}
</style>