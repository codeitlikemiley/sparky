<modal :name="project.slug">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title align-center">Progress <span @click="hide(project.slug)" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content" v-show="campaigns.length > 0">
            <div v-for="campaign in campaigns"> 
            <progress-bar :name="campaign.name" :progress="campaignProgress(campaign)"></progress-bar>
            </div>
        </div>
        <div class="content" v-show="campaigns.length == 0">
            <div class="v-align-middle align-center">
            <strong class="fg-darkCobalt">Please Create A Campaign...</strong>
            </div>
        </div>
    </div>
</modal>