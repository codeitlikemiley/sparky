@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }
</style>
@endpush
<modal name="edit-project" :width="500" :height="500" draggable=".window-header">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title window-header">Edit Client Name<span @click="closeEditProjectModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                    @if($guard === 'web')
                    <div class="input-control text full-size">
                    <form @submit.prevent="updateProjectName()" role="form" class="padding10">
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-folder-special fg-yellow"></span>
                                <input type="text" placeholder="Describe Your Client?" v-model="editProjectForm.client_name">
                                <span class="fg-red" v-show="editProjectForm.errors.has('client_name')">
                                @{{ editProjectForm.errors.get('client_name') }}
                            </span>
                            </div>
                        </div>
                        <button type="submit" class="button fg-white" :class="{'bg-teal': !editProjectForm.busy,'bg-red': editProjectForm.busy}" style="position:absolute;top:24px;right: 17px; height:43px;" :disabled="editProjectForm.busy">
                                <span class="icon mif-keyboard-return" v-if="!editProjectForm.busy"> Update</span>
                                <span class="icon mif-spinner mif-ani-spin" v-else></span>
                        </button>
                    </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</modal>