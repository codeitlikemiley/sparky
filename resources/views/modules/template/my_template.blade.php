@push('critical_css')
<style>
.tabcontrol .frames .frame .removeborder {
    padding: 0 !important;
}
</style>
@endpush

<div class="frame bg-white margin-bottom-90" id="my_template" v-if="mytemplates.length >0" style="min-height:450px;">
        <div class="panel widget-box collapsible" data-role="panel">
            <div class="row cells2" v-for="(myChunk, myKeyChunk, myIndexChunk) in myTemplateChunks(mytemplates)"
                :key="myKeyChunk" :index="myIndexChunk">
    
                <div class="cell colspan1" v-for="(mytemplate, mycKey, mycIndex) in myChunk" style="min-height: 150px;" :index="mycIndex" :key="mycKey" 
                >
                    <div class="panel">
                        <div class="heading bg-lightBlue">
                            <div style="position:absolute;top:12px;margin-left:136px;">
                                <span>
                                    @{{ mytemplate.name }}
                                </span>
                            </div>
                            <!-- Add Check All Button that will Select All Campaigns -->
                            <div v-if="guard === 'web'" @click="cloneMyTemplate(mytemplate.id)" class="align-center bg-cyan place-left" style="cursor:pointer;position:absolute;top:0;left:0;width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Clone|Template" data-hint-position="top">
                                <span class="icon  mif-stack3" style="position: relative;top: 50% !important; transform: translateY(-50%) !important;"></span>
                            </div>  
                            <!-- Only show the delete button to SuperAdmin -->
                            <div v-if="guard === 'web'" @click="deleteMyTemplate(mycKey,mytemplate)" class="align-center bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Delete|Template" data-hint-position="top">
                                <span class="icon fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                            </div>
                        </div>
                        <div class="content">
                                <ul class="todo-list" v-if="mytemplate.campaigns">
                                    <!-- all list of campaign checked -->
                                    <mycampaignlist :campaignlist="mytemplate.campaigns" :template="mytemplate.id">
                                    </mycampaignlist>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="show-myjobs-modal" width="50%" height="82%" :scrollable="true">
            <div class="panel widget-box" v-if="mycurrent_campaign">
                <div class="heading align-center">
                    <div class="title">Jobs List For: @{{ mycurrent_campaign.name }}<span @click="closeMyJobsModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
                </div>
                <div class="content">
                    <div class="accordion" data-role="accordion">
                        <div class="frame active removeborder" v-for="(mytask, mytKey, mytIndex) in mycurrent_campaign.tasks" :key="mytKey" :index="mytIndex">
                            <div class="heading">Tasks For Job : @{{ mytask.name }}
                                <span class="icon mif-list" style="font-size:1.5em;position:absolute;top:5px;right:5px;"></span>
                            </div>
                            <div class="content">
                                    <ol class="todo-list numeric-list" style="margin-top:-5px;">
                                    <li v-for="(mysubtask,mysKey,mysIndex) in mytask.subtasks" :index="mysIndex" :key="mysKey">
                                        <span class="tag success" style="margin-top:-3px;">@{{ mysubtask.name }}</span>
                                    </li>
                                    </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>  
    </div>
    <div class="frame bg-white margin-bottom-90" id="my_template" v-else style="min-height:450px;">
            <h2 class="fg-teal align-center"><span class="tag bg-red fg-white">You Have No Available Templates.</span></h2>
            <h2 class="fg-teal align-center" style="padding-bottom:250px;"><span class="tag success" @click="goToDashboard()" style="cursor:pointer;">Clone an Existing Project Or Create then Clone A Project</span></h2>    
        </div>
            
    