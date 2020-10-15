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
				<div class="box">FINALIZADO</div>
			</div>
		</div>
		<div class="p-grid">
			<div class="p-col">
				<div class="swimlane">
					<div class="issue" @click="toggleMenuDetail">
						<div class="issue-content">
							<div class="issue-key">
								<span>#76246</span>
							</div>
							<div class="issue-subject">
								<span>Seminovos - Gabriel Ulbrich - 76246</span>
							</div>
							<div class="issue-date">
								<span>14 Ago</span>
							</div>
							<div class="issue-footer">
								<span class="issue-avatar">
									<img src="https://jira.uhub.biz/secure/useravatar?avatarId=14125" alt="Assignee: Gabriel Ulbrich">
								</span>
								<span class="issue-priority">
									<img src="https://jira.uhub.biz/images/icons/priorities/highest.svg">
								</span>
							</div>
						</div>		
						<div class="issue-grabber" style="background-color:#bfe4ff;"></div>				
					</div>
				</div>
			</div>
			<div class="p-col">
				<div class="swimlane"></div>
			</div>
			<div class="p-col">
				<div class="swimlane"></div>
			</div>
		</div>

		<MenuDetail :active="active"/>

	</div>
</template>

<script>
import MenuDetail from '@/components/MenuDetail.vue';

export default {
	data(){
		return{
			active: false
		}
	},
    methods: {
        toggleMenuDetail() {
			this.active = !this.active
        }
	},
	components: {
		MenuDetail,
    }
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
	padding-top: 1rem;
	padding-bottom: 1rem;
	border-radius: 4px;
	min-height: 100vh;
}	


.issue {
    padding: 2px 8px 4px 8px;
    background: #fff;
    color: #172b4d;
    cursor: move;
    display: block;
    font-size: 14px;
    line-height: 1.42857143;
    position: relative;
    box-shadow: 0 0 1px 0 rgba(9,30,66,0.31), 0 2px 4px -1px rgba(9,30,66,0.25);
    border-radius: 2px;
    margin: 5px;
	text-align: left;

	&-key{
		font-weight: 600;
	}

	&-subject {
		margin-top: 5px;
	}

	&-grabber{
		height: 100%;
		left: 0;
		position: absolute;
		text-indent: -9999em;
		top: 0;
		width: 3px;
		border-top-left-radius: 3px;
		border-bottom-left-radius: 3px;
		width: 3px;
		background-color: #bfe4ff;
		margin: 0;
		padding: 0;
	}

	&-footer{
		margin-top: 10px;
		margin-right: 4px;
		margin-bottom: 3px;
		img{
			height: 16px;
			width: 16px;
			overflow: hidden;
			margin-right: 4px;
			margin-bottom: 4px;
		}
	}
}


/* 

highsted = https://jira.uhub.biz/images/icons/priorities/highest.svg
high = https://jira.uhub.biz/images/icons/priorities/high.svg
medium = https://jira.uhub.biz/images/icons/priorities/medium.svg
low = https://jira.uhub.biz/images/icons/priorities/low.svg



*/
</style>
