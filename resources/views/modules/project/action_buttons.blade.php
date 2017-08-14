<div>
    <a href="#!" v-if="guard === 'web'">
        <button @click="showCampaignModal()" class="button info"><span class="mif-plus"></span> Add New Campaign</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="show('edit-project')" class="button info"><span class="mif-pencil"></span> Edit Client</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="deleteProject()" class="button alert"><span class="icon fa fa-trash"></span> Delete Client</button>
    </a>
</div>