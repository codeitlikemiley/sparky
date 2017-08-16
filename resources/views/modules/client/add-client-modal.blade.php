@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }

</style>
@endpush
<modal name="add-client-modal" :pivot-x=".5" :pivot-y=".1" :adaptive="true" width="500px" height="auto" :scrollable="true">
    <form @submit.prevent="addClient()" role="form" class="">
    <div class="panel widget-box">

        <div class="heading" style="background-color:#4db6ac;">
            <div class="title align-center">Create New Client<span @click="closeAddClientModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
        </div>

        <div class="content">

                <div class="text">

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-user fg-lime"></span>
                            <input type="text" placeholder="Client Name" v-model="registerForm.name">
                            <span class="fg-red" v-show="registerForm.errors.has('name')">
                        @{{ registerForm.errors.get('name') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-link fg-blue"></span>
                            <input type="text" placeholder="Client Website" v-model="registerForm.website">
                            <span class="fg-red" v-show="registerForm.errors.has('website')">
                        @{{ registerForm.errors.get('website') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-mail fg-yellow"></span>
                            <input type="text" placeholder="Client Email" v-model="registerForm.email">
                            <span class="fg-red" v-show="registerForm.errors.has('email')">
                        @{{ registerForm.errors.get('email') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;margin-bottom:15px;">
                        <div class="input-control text full-size">
                            <span v-if="registerForm.hidden" class="prepend-icon mif-spell-check fg-darkCyan" @click="registerForm.hidden = false"></span>
                            <span v-else class="prepend-icon mif-eye fg-darkCyan" @click="registerForm.hidden = true"></span>
                            <input v-if="registerForm.hidden" type="password" placeholder="Client Password" v-model="registerForm.password">
                            <input v-else type="text" placeholder="Password Visible" v-model="registerForm.password">
                            <span class="fg-red" v-show="registerForm.errors.has('password')">
                            @{{ registerForm.errors.get('password') }}
                        </span>
                        </div>
                    </div>
                    <v-select style="margin-bottom:50px;" max-height="160px" class="full-size" multiple v-if="projects.length > 0" v-model="registerForm.assignedProjects" label="slug" :options="projects"  placeholder="Pick Unassigned Projects For this Client"></v-select>
                    
                    <div  class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <label class="switch pull-left">
                                <input type="checkbox" v-model="registerForm.new_project">
                                <span class="check"></span>
                                <span class="caption" v-if="!registerForm.new_project">Create New Project?</span>
                                <span class="caption" v-else>Create Project</span>
                            </label>
                            <span v-if="registerForm.new_project" @click="newProjectInput()" class="pull-right" style="margin-top:-17px;cursor:pointer;padding-right:5px;"><span class="icon mif-folder-plus fg-green"></span></span>
                        </div>
                    </div>
                    <div v-if="registerForm.new_project" v-for="(project,projectKey, projectIndex) in registerForm.projects" :key="projectKey" :index="projectIndex" style="margin-bottom:20px;">
                        <div class="full-size">Project @{{ projectKey + 1 }}<span @click="removeProjectInput(projectKey)" class="icon mif-folder-minus fg-red pull-right" style="padding-right:10px;cursor:pointer;"></span></div>
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-folder-special fg-amber"></span>
                                <input type="text" placeholder="Describe Briefly This Client Project" v-model="project.name">
                                <span class="fg-red" v-show="registerForm.errors.has(`projects.${projectKey}.name`)">
                                @{{ registerForm.errors.get(`projects.${projectKey}.name`) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
    <div class="row" style="position: absolute;width: 100%;bottom:0;">
        <button type="submit" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#558b2f;">
            <strong>Create Client Account</strong>
        </button>
    </div>
    </form>
</modal>