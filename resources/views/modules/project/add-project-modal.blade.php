<modal name="add-project">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Create New Project <span @click="hide('add-project')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                    @if($guard === 'web')
                    <div class="input-control text full-size">
                    <form @submit.prevent="createProject()" role="form" class="padding10">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Type Project Name" v-model="projectForm.project_name">
                        </br>
                        </br>

                        <v-select v-if="clients.length > 0" v-model="projectForm.client_id" label="name" :options="clients"  placeholder="Choose a Client"></v-select>
                        <button type="submit" class="button info place-right" style="position:absolute;top:64px;right: 12px; height:36px;">
                                <span class="icon mif-keyboard-return"> Create</span>
                        </button>
                    </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</modal>