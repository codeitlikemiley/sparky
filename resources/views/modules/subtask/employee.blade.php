@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }

</style>
@endpush
<div class="frame bg-white" id="people_tab" v-if="subtaskForm.assignedEmployees.length >0" style="min-height:600px;padding-bottom:100px;">
    <div class="row" style="padding-top:100px;">
            <v-select  style="margin-bottom:50px;margin-top:-50px;" multiple max-height="160px" class="full-size" v-model="subtaskForm.assignedEmployees" label="name" :options="options"  placeholder="Assigned Existing Team Member"></v-select>
    </div>
    <div class="row cells4" v-for="(chunk, chunkKey) in employeeChunks" :key="chunkKey">
            <div class="cell" v-for="(employee, employeeKey) in chunk" :key="employeeKey">
                <a   style="cursor:pointer;">
                    <img :src="employee.photo_url" 
                        :alt="employee.name"
                        style="border: 2px solid #d3e0e9;
                            border-radius: 50%;
                            height: 40px;
                            padding: 2px;
                            width: 40px;
                            height: 50px;
                            width: 50px;"
                    >
                    @{{ employee.name }}
                </a>
            </div>
        </div>
    </div>
    <div class="frame bg-white" id="people_tab" v-else>
        <div class="row" style="min-height:450px;">
            <div class="cell align-center">
                <h4 class="fg-lightRed">No Team Member Yet is Assigned To Any Of The Task For this Job!</h4>
                <h4 class="tag bg-blue fg-white" style="cursor:pointer; font-size:20px;"><strong @click="goToTask()">Create a New Task and Assign A Team Member To That Task</strong></h4>
            </div>
        </div>
        
    </div>