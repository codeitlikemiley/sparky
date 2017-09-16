<div class="frame bg-white" id="view_tab">
    <div class="example">
        <blockquote class="align-center fg-teal">
            <strong><h2 title="Source Title">@{{ subtask.name }}</h2></strong>
        </blockquote>
        <a class="icon mif-trophy fg-amber">
        @{{ subtask.points }}<span v-if="subtask.points > 1"> points</span> <span v-else> point</span>
        </a>

        <a style="position:absolute;top:0;right:0;font-size:1em;">
            <span class="tag bg-green fg-white" v-if="subtask.done"><span class="icon mif-checkmark"></span> DONE</span>
            <span class="tag bg-red fg-white" v-else-if="overDueDate(subtask)">Overdue @{{ subtask.due_date |date }}</span>
            <span class="tag bg-amber fg-white" v-else>Deadline: @{{ subtask.due_date|date }}</span>
        </a>
        <a v-if="!subtask.description && guard === 'web'" @click="updateDescription()" style="position:absolute;bottom:0;right:0px;font-size:1em;cursor:pointer;">
                <span class="tag info"><span class="icon mif-plus"></span> Add Task Description</span>
        </a>
        <a><star-rating @rating-selected="setRating" v-model="subtask.priority" :star-size="23" :show-rating="false"></star-rating></a>
    </div>
    <div v-if="!subtask.description" style="min-height:500px;padding-bottom:100px;">
            
            <trumbowyg :config="configs.advanced" v-model="subtask.description"></trumbowyg>
    </div>
    <div v-else class="example" v-html="subtask.description"></div>
    
</div>
    