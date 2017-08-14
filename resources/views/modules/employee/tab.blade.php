<div class="frame bg-white" id="people_tab" v-if="employees">
    <div class="row cells4" v-for="(chunk, index) in employeeChunks" :key="chunk.id" :index="index" :chunk="chunk">
        <div class="cell" v-for="(employee, index) in chunk" :key="employee.id" :index="index" :employee="employee">
            <a href="javascript:void(0);" onclick="alert('Please Create Show User Profile Component');">
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
            <h4 class="fg-lightRed">Opps! No Team Member Assigned Yet To This Client...</h4>
            <h4 class="fg-cyan"><strong>Create A Task First Under Jobs And Assign A Team Member to It.</strong></h4>
        </div>
    </div>
    
</div>