<div class="frame bg-white" id="people_tab">
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