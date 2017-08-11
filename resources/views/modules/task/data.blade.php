<div class="example" data-text="Link">
    <blockquote class="place-right">
        <p v-text="taskForm.task_description" v-if="taskForm.task_description"></p>
        <p v-else @click="editTaskModal()" style="cursor:pointer;"><span class="tag info">Add Description</span></p>
        <small><cite title="Source Title">@{{ taskForm.task_name }}</cite></small>
    </blockquote>
    <a @click="viewLink()" class="tag info" v-if="taskForm.task_link">
        <span class="tag info">@{{ taskForm.task_link }}</span>
    </a>
    <a v-else @click="editTaskModal()" style="cursor:pointer;"><span class="tag info">Add Link</span></a>
    <a v-if="taskForm.task_recurring" style="position:absolute;bottom:0;right:35px;font-size:1em;">
        <span class="tag success"><span class="icon mif-loop"></span> Repeat Task Every @{{ taskForm.task_interval }} Day</span>
    </a>
</div>
<a v-if="guard ==='web'" @click="deleteTaskModal()" class="place-right margin10">
    <button class="button bg-lightRed fg-white"><span class="icon fa fa-trash "></span> Delete Task</button>
</a>
<a v-if="guard ==='web'" @click="editTaskModal()" class="place-right margin10">
    <!-- Open Modal To Edit Task -->
    <button class="button info"><span class="mif-pencil"></span> Edit Task</button>
</a>
