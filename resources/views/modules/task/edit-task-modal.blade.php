<modal name="edit-task-modal" :width="500" :height="400" draggable=".window-header">
        <form @submit.prevent="updateTask()" role="form" class="">
        <div class="panel widget-box">
    
            <div class="heading" style="background-color:#4db6ac;">
                <div class="title window-header align-center">Edit Task <span @click="hide('edit-task-modal')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
    
            <div class="content">
    
                    <div class="text">
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-file-text"></span>
                                <input type="text" placeholder="Add Name" v-model="taskForm.task_name">
                                <span class="fg-red" v-show="taskForm.errors.has('task_name')">
                                @{{ taskForm.errors.get('task_name') }}
                            </span>
                            </div>
                        </div>
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-link"></span>
                                <input type="text" placeholder="Add Link" v-model="taskForm.task_link">
                                <span class="fg-red" v-show="taskForm.errors.has('task_link')">
                            @{{ taskForm.errors.get('task_link') }}
                            </span>
                            </div>
                        </div>
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <textarea placeholder="Add Description" v-model="taskForm.task_description"></textarea>
                                <span class="fg-red" v-show="taskForm.errors.has('task_description')">
                            @{{ taskForm.errors.get('task_description') }}
                            </span>
                            </div>
                        </div>
    
                    </div>
            </div>
    
        </div>
        <div class="row" style="position: absolute;width: 100%;bottom:0;">
            <button type="submit" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#558b2f;">
                <strong>Submit</strong>
            </button>
        </div>
        </form>
    </modal>