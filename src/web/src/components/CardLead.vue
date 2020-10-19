<template>
    <div class="issue" >
        <div class="issue-content">
            <div class="issue-key">
                <router-link class="lead-page" :to="{name: 'lead', params: {id: lead.id}}">
                    <span>#{{ lead.id }}</span>
                </router-link>
            </div>
            <div class="issue-subject">
                <span>{{ lead.summary }}</span>
            </div>
            <div class="issue-date">
                <span>{{ lead.created }}</span>
            </div>
            <div class="issue-footer">
                <span class="issue-avatar">
                    <img :src="lead.user.avatar_url" alt="Assignee: Gabriel Ulbrich">
                </span>
                <span class="issue-priority">
                    <img :src="lead.priority.icon">
                </span>
            </div>
        </div>		
        <div class="issue-grabber" style="background-color:#bfe4ff;"></div>				
    </div>  
</template>

<script>
export default {
    props: ["lead"],
    methods: {
        toggleMenuDetail() {
			console.log('test')
        }
	},
}
</script>

<style lang="scss" scoped>
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
