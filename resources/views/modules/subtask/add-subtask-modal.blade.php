@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none
    }
</style>
@endpush
<modal name="add-subtask-modal" :width="500" :height="670" draggable=".window-header">
        <form @submit.prevent="addSubtask()" role="form" class="">
        <div class="panel widget-box">
    
            <div class="heading" style="background-color:#4db6ac;">
                <div class="title window-header align-center">Add Subtask <span @click="hide('add-subtask-modal')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
    
            <div class="content">
    
                    <div class="text">
    
                        <div class="row" style="padding:5px;margin-bottom:10px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-file-text fg-lime"></span>
                                <input type="text" placeholder="Add Name" v-model="subtaskForm.name">
                                <span class="fg-red" v-show="subtaskForm.errors.has('name')">
                                @{{ subtaskForm.errors.get('name') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;">
                        <v-select class="full-size" multiple v-if="employees.length > 0" v-model="subtaskForm.employees" label="name" :options="employees"  placeholder="Assigned Team Member"></v-select>
                        </div>
                        <!-- show button to create new Team -->
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-trophy fg-yellow"></span>
                                <input type="number" placeholder="Add Points" v-model="subtaskForm.points">
                                <span class="fg-red" v-show="subtaskForm.errors.has('points')">
                                @{{ subtaskForm.errors.get('points') }}
                            </span>
                            </div>
                        </div>
                        <div class="panel widget-box full-size">
                                <div class="heading">
                                    <div class="title">Priorities</div>
                                </div>
                                <div class="content">
                                    <div class="text">
                                        <star-rating :padding="77"  @rating-selected="setPriority" v-model.number="priority" :star-size="30" :show-rating="false"></star-rating>
                                    </div>
                                </div>
                        </div>
                        <div class="row" style="padding:5px;margin-top:-90px;">
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
                        
                    </div>
            </div>
        </div>
        <div class="row" style="position: absolute;width: 100%;bottom:0;">
            <button type="submit" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#558b2f;">
                <strong>Create A New Subtask</strong>
            </button>
        </div>
        </form>
    </modal>