<template>
	<!-- <div>
		
	</div> -->

	
		
	<div class="p-grid">
			<div class="p-col-12">
				<div class="header">
					<div class="header-image">
						<img src="https://issues.redhat.com/secure/projectavatar?pid=12318028&avatarId=25966" alt="Logo">
					</div>
					<div class="header-main">
						<span>Volvo / 48</span>
						<h1 class="header-main__title">SUMARIO DO TItULO (PODE EDITAR)</h1>
					</div>
				</div>
			</div>
			<div class="p-col">
				<div class="details">
					<ul class="details-two-cols">
						<li class="details-item right">
							<span class="name">Prioridade:</span>
							<span class="value">Muito Alta</span>
						</li>
						<li class="details-item">
							<span class="name">Prioridade:</span>
							<span class="value">Muito Alta</span></li>
						<li class="details-item">
							<span class="name">Prioridade:</span>
							<span class="value">Muito Alta</span></li>
						<li class="details-item">
							<span class="name">Prioridade:</span>
							<span class="value">Muito Alta</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="p-col-fixed" style="width:35%">
				<div class="box">100px</div>
			</div>		
	</div>
</template>

<script>
import { api } from "@/services.js";

export default {
	components: {
    },
	data(){
		return{
			lead: null,
			errors: [],
		}
	},
    methods: {

	},
	created(){
		console.log('create')
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
	margin-top: 30px;
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

		span{
			width: 50%;
			float: left;
		}
	}
	.right{
		clear: right;
		float: right;
	}
}
</style>
