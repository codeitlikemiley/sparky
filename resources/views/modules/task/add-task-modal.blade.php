<modal name="add-task" :width="700" :height="650">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Add Task <span @click="hideTask()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <form @submit.prevent="createTask()" role="form" class="padding10">
                <div class="row">

                    <div class="input-control text full-size">
                        <input type="text" placeholder="Add Task" v-model="taskForm.name">
                        <button type="submit" class="button info" :disabled="taskForm.busy">
                            <span class="icon mif-keyboard-return"></span>
                    </button>
                    </div>
                    <span class="help-block" v-show="taskForm.errors.has('name')">
                        @{{ taskForm.errors.get('name') }}
                    </span>

                </div>
            </form>
        </div>
    </div>
</modal>