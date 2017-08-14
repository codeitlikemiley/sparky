@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }
</style>
@endpush
<modal name="edit-project" :width="500" :height="450" draggable=".window-header">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title window-header">Edit Client<span @click="hide('edit-project')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                    @if($guard === 'web')
                    <div class="input-control text full-size">
                    <form @submit.prevent="updateProject(project.id)" role="form" class="padding10">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Describe Your Client?" v-model="projectForm.client_name">
                        </br>
                        </br>
                        
                        <v-select max-height="200px" v-if="clients.length > 0 && projectForm.newclient == false" v-model="projectForm.client_id" label="name" :options="clients"  placeholder="Pick an Existing Client"></v-select>
                        <!-- we need to easily create a client without an email or had a default email -->
                        <button type="submit" class="button info place-right" style="position:absolute;top:64px;right: 12px; height:36px;">
                                <span class="icon mif-keyboard-return"> Update</span>
                        </button>
                    </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</modal>