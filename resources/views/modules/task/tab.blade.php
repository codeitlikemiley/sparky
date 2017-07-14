<div class="frame bg-white" id="tasks_tab">

    <div class="panel widget-box">

        <div class="row cells2" style="padding: 20px;background-color:#bbdefb;" v-for="(chunk, keyChunk) in campaignChunks(campaigns)"
            :key="keyChunk">
            <draggable class="cell draghandle" v-for="(campaign, cKey) in chunk" :options="{group: 'campaign',handle: '.draghandle',filter: '.v--modal-box,.v--modal',scroll: true,preventOnFilter: false}"
                :data-id="campaign.id" :key="cKey" @end="onEnd" style="min-height: 150px;" :leftOrRight="cKey" :max="keyChunk"
                :data-id="campaign.id">
                <div class="panel">

                    <div class="heading align-center bg-lightBlue" style="cursor:move;">
                        <span class="">@{{ campaign.name }}</span>
                        <span class="icon  fa fa-pencil-square-o bg-steel" @click="editCampaignModal(campaign)" style="cursor:pointer;"></span>

                        <div @click="deleteCampaign(campaign)" class="bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;">
                            <i class="fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="content">
                        <div class="listview set-border padding10" data-role="listview">

                            <div class="list-group">
                                <div class="list-group-content">
                                    <div class="list" @click="viewTask(task.id)" v-for="(task, tKey) in campaign.tasks" :key="tKey">
                                        <span>
                                            <span class="mif-clipboard fg-teal">
                                            </span>
                                        </span>
                                        <span class="fg-amber">
                                        @{{ task.done_points }}
                                        </span>
                                        <strong class="fg-teal">/</strong>
                                        <span class="fg-green">@{{ task.total_points}}</span>
                                        <span class="fg-teal">@{{ task.name }}</span>
                                        <a href="#!">
                                            <span style="float: right;">
                                                <span class="icon fa fa-tasks fg-lightBlue">
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div style="padding-left:50px;">
                                        <button @click="showTask(campaign.id)" class="button info">Add New Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </draggable>
            @include('campaign::edit-campaign-modal')
            </div>
        </div>
    </div>
</div>