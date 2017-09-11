<div class="frame bg-white" id="job_tab">
<div class="example" data-text="Link">
    <blockquote class="place-right">
        <small><cite title="Source Title">@{{ taskForm.task_name }}</cite></small>
    </blockquote>
    
    <a @click="viewLink()" class="tag info" v-if="taskForm.task_link">
        <span class="tag info">@{{ taskForm.task_link }}</span>
    </a>
    <a v-else @click="editTaskModal()" style="cursor:pointer;"><span class="tag info">Add Link</span></a>
    <a v-if="taskForm.task_recurring" style="position:absolute;bottom:0;right:35px;font-size:1em;">
        <span class="tag success"><span class="icon mif-loop"></span> Repeat Job Every @{{ taskForm.task_interval }} Day</span>
    </a>
</div>
<div class="example align-center">
    <a v-if="guard ==='web'" @click="editTaskModal()" class="margin10">
        <!-- Open Modal To Edit Task -->
        <button class="button info"><span class="mif-pencil"></span> Edit Job</button>
    </a>
    <a v-if="guard ==='web'" @click="deleteTaskModal()" class="margin10">
        <button class="button bg-lightRed fg-white"><span class="icon fa fa-trash "></span> Delete Job</button>
    </a>
    <a v-if="guard ==='web' && !showEditor" @click="openEditor()" class="margin10">
        <button class="button bg-darkTeal fg-white" :disabled="taskForm.busy"><span class="icon fa fa-sticky-note "></span> Job Page Editor</button>
    </a>
    <a v-if="guard ==='web' && showEditor"  @click="editDescription()" class="margin10">
        <button class="button bg-teal fg-white" :disabled="taskForm.busy"><span class="icon fa fa-sticky-note "></span> Update Job Page</button>
    </a>
</div>

<div v-if="!showEditor" class="example" v-html="taskForm.task_description" v-if="taskForm.task_description"></div>


<div v-if="showEditor" style="min-height:500px;padding-bottom:100px;">
    <text-editor :description="taskForm.task_description"></text-editor>
</div>

</div>
