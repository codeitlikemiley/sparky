@push('critical_css')
<style>
.truncate {
  width: 50%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
@endpush
<div class="frame bg-white margin-bottom-90" id="tasks_tab">
    <div class="panel widget-box collapsible" data-role="panel">
        <div class="row cells2" v-for="(chunk, keyChunk) in campaignChunks(campaigns)"
            :key="keyChunk">

            <draggable class="cell colspan1 draghandle" v-for="(campaign, cKey) in chunk" :options="{group: 'campaign',handle: '.draghandle',filter: '.v--modal-box,.v--modal',scroll: true,preventOnFilter: false}"
                :data-id="campaign.id" :key="cKey" @end="onEnd" style="min-height: 150px;" :leftOrRight="cKey" :max="keyChunk"
                :data-id="campaign.id">
                <div class="panel">

                    <div class="heading  bg-lightBlue" style="cursor:move;">
                        <div class="truncate" style="cursor:pointer;position:absolute;top:12px;margin-left:136px;">
                            <span data-role="hint" data-hint-mode="2" data-hint="Switch|Re-Order Campaign" data-hint-position="top">
                                @{{ campaign.name }}
                            </span>
                        </div>
                        <div @click="editCampaignModal(campaign)" class="align-center bg-cyan place-left" style="cursor:pointer;position:absolute;top:0;left:0;width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Edit|Campaign" data-hint-position="top">
                            <span class="icon  fa fa-pencil-square-o" style="position: relative;top: 50% !important; transform: translateY(-50%) !important;"></span>
                        </div>
                        <div @click="showTask(campaign.id)" class="align-center bg-amber place-left" style="cursor:pointer;position:absolute;top:0;margin-left:53px; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Add|Task" data-hint-position="top">
                            <span class="icon mif-plus" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                        </div>
                        <div @click="deleteCampaign(campaign)" class="align-center bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Delete|Campaign" data-hint-position="top">
                            <span class="icon fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                        </div>
                    </div>
                    <div class="content">
                        <div class="text">
                            <ul class="todo-list">
                                <li v-for="(task, tKey) in campaign.tasks" :key="tKey" style="padding:10px;">
                                    <label class="input-control checkbox" onclick="return false;" style="cursor:default;">
                                        <input type="checkbox" class="todo-cb" v-model="task.done">
                                        <span class="check"></span>
                                        <span class="caption" :class="{ 'todo-completed': isTaskDone(task) }">@{{ task.name }}</span>
                                    </label>
                                    <div @click="viewTask(task.id)" class="place-right" style="cursor:pointer;">
                                        <span data-role="hint" data-hint-mode="2" data-hint="View|Task" data-hint-position="left" class="icon fg-green fa fa-tasks vertical-align-middle" style="position: relative;padding-top:8px;font-size:2.5em;"></span>
                                        <span data-role="hint" data-hint-mode="2" data-hint="Progress|Done Points / Total Points" data-hint-position="left" class="math-box place-left" style="padding:11px;"><span class="strut" style="height: 2.008em; vertical-align: -0.686em;"></span><span class="vstack"><div style="top: 0.686em;color:#80cbc4;">@{{ task.total_points}}</div><div style="top: -0.23em;"><span class="frac-line"></span></div><div style="top: -0.677em;color: #e57373;">@{{ task.done_points }}</div><span class="baseline-fix"></span></span></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
            </draggable>
            @include('campaign::edit-campaign-modal')
            </div>
        </div>
    </div>
</div>