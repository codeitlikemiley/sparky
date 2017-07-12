<modal :name="slug(campaign.name)">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Edit @{{campaignForm.campaign_name}} <span @click="hide(slug(campaign.name))" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <form @submit.prevent="updateCampaign(index_campaign,campaign)" role="form" class="padding10">
                <div class="row">

                    <div class="input-control text full-size">
                        <input type="text" placeholder="Edit" v-model="campaignForm.campaign_name">
                        <input type="number" placeholder="Campaign Order" v-model="campaignForm.campaign_order">
                        <button type="submit" class="button info" :disabled="campaignForm.busy">
                            <span class="icon mif-keyboard-return"></span>
                    </button>
                    </div>
                    <span class="help-block" v-show="campaignForm.errors.has('campaign_name')">
                        @{{ campaignForm.errors.get('campaign_name') }}
                    </span>

                </div>
            </form>
        </div>
    </div>
</modal>