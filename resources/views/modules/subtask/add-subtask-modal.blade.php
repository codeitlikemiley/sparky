@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }

</style>
@endpush
<modal name="add-subtask-modal" :pivot-x=".5" :pivot-y=".1" :adaptive="true" width="500px" height="auto" :scrollable="true">
        <form @submit.prevent="addSubtask()" role="form" class="">
                <div class="panel widget-box">
            
                    <div class="heading" style="background-color:#4db6ac;">
                        <div class="title window-header align-center">Add Task <span @click="hide('add-subtask-modal')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
                    </div>
            
                    <div class="content">
            
                            <div class="text">
            
                                <div class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-file-text fg-lime"></span>
                                        <input type="text" placeholder="Add Name" v-model="subtaskForm.name">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('name')">
                                        @{{ subtaskForm.errors.get('name') }}
                                    </span>
                                    </div>
                                </div>
                                
                                <div class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-trophy fg-yellow"></span>
                                        <input type="number" placeholder="Add Points" v-model="subtaskForm.points">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('points')">
                                        @{{ subtaskForm.errors.get('points') }}
                                    </span>
                                    </div>
                                </div>
                                <div class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-video-camera fg-indigo"></span>
                                        <input type="text" placeholder="Add Video Link" v-model="subtaskForm.link">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('link')">
                                    @{{ subtaskForm.errors.get('link') }}
                                    </span>
                                    </div>
                                </div>
                                <div class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-calendar fg-amber"></span>
                                        <input type="date" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"  v-model="subtaskForm.due_date">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('due_date')">
                                    @{{ subtaskForm.errors.get('due_date') }}
                                    </span>
                                    </div>
                                </div>
                                <div class="row" style="padding:5px;margin-bottom:15px;">
                                        <div class="pull-left">
                                            <h4>Set Priorities :</h4>
                                        </div>
                                         <star-rating style="position:absolute;right:0;top:285px;margin-right:-20px;" :padding="40" @rating-selected="setPriority" v-model.number="priority" :star-size="30" :show-rating="false"></star-rating>
                                </div>
                                <v-select style="margin-bottom:50px;" max-height="160px" class="full-size" multiple v-if="options.length > 0" v-model="subtaskForm.assignedEmployees" label="name" :options="options"  placeholder="Assigned Existing Team Member"></v-select>
                                <div  class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <label class="switch pull-left">
                                            <input type="checkbox" v-model="subtaskForm.sendEmail">
                                            <span class="check"></span>
                                            <span class="caption" v-if="!subtaskForm.sendEmail">Notify Team Members?</span>
                                            <span class="caption" v-else>Send Email</span>
                                        </label>
                                        <span class="tag warning" v-if="subtaskForm.sendEmail">Sending Email Takes Time</span>
                                    </div>
                                </div>
                                <div  class="row" style="padding:5px;">
                                    <div class="input-control text full-size">
                                        <label class="switch pull-left">
                                            <input type="checkbox" v-model="subtaskForm.newCollaborator">
                                            <span class="check"></span>
                                            <span class="caption" v-if="!subtaskForm.newCollaborator">Assign New Teammate?</span>
                                            <span class="caption" v-else>Create New Teammate</span>
                                        </label>
                                        <span v-if="subtaskForm.newCollaborator" @click="newUserInput()" class="pull-right" style="margin-top:-17px;cursor:pointer;padding-right:5px;"><span class="icon mif-user-plus fg-green"></span></span>
                                    </div>
                                </div>
                                <!-- New Collaborator -->
                                <div v-if="subtaskForm.newCollaborator" v-for="(user,userKey, userIndex) in subtaskForm.users" :key="userKey" :index="userIndex" style="margin-bottom:20px;">
                                    <div class="full-size">Teammate @{{ userKey + 1 }}<span @click="removeUserInput(userKey)" class="icon mif-user-minus fg-red pull-right" style="padding-right:10px;cursor:pointer;"></span></div>
                                    <div class="row" style="padding:5px;">
                                        <div class="input-control text full-size">
                                            <span class="prepend-icon mif-user fg-blue"></span>
                                            <input type="text" placeholder="Member Name" v-model="user.name">
                                            <span class="fg-red" v-show="subtaskForm.errors.has(`users.${userKey}.name`)">
                                            @{{ subtaskForm.errors.get(`users.${userKey}.name`) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:5px;">
                                        <div class="input-control text full-size">
                                            <span class="prepend-icon mif-mail fg-blue"></span>
                                            <input type="text" placeholder="Member Email" v-model="user.email">
                                            <span class="fg-red" v-show="subtaskForm.errors.has(`users.${userKey}.email`)">
                                            @{{ subtaskForm.errors.get(`users.${userKey}.email`) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:5px;">
                                        <div class="input-control text full-size">
                                            <span class="prepend-icon mif-spell-check fg-blue"></span>
                                            <input type="text" placeholder="Member Password" v-model="user.password">
                                            <span class="fg-red" v-show="subtaskForm.errors.has(`users.${userKey}.password`)">
                                            @{{ subtaskForm.errors.get(`users.${userKey}.password`) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- New Collaborator -->
                            </div>
                    </div>
                </div>
                <div class="row" style="position: absolute;width: 100%;bottom:0;">
                    <button type="submit" class="button fg-white" :class="{'bg-teal': !subtaskForm.busy,'bg-red': subtaskForm.busy}" style="width:500px; margin-bottom:-1px;" :disabled="subtaskForm.busy">
                        <strong v-if="!subtaskForm.busy">Update Task</strong>
                        <strong v-else>Please Wait...</strong>
                    </button>
                </div>
                </form>     
</modal>