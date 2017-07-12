<modal name="edit-project">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Edit @{{ projectForm.project_name }} <span @click="hide('edit-project')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <form @submit.prevent="updateProject(project.id)" role="form" class="padding10">
                <div class="row">

                    <div class="input-control text full-size">
                        <input type="text" placeholder="Edit Project" v-model="projectForm.project_name">
                        <v-select  v-if="clients.length > 0" v-model="projectForm.client_id" label="name"  :options="clients" placeholder="Choose a Client"></v-select>
                        <button type="submit" class="button info" :disabled="projectForm.busy">
                            <span class="icon mif-keyboard-return"></span>
                    </button>
                    </div>
                    <span class="help-block" v-show="projectForm.errors.has('project_name')">
                        @{{ projectForm.errors.get('project_name') }}
                    </span>

                </div>
            </form>
        </div>
    </div>
</modal>