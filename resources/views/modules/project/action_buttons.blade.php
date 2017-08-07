<div>
    <a href="#!" v-if="guard === 'web'">
        <button @click="show('add-campaign')" class="button info"><span class="mif-plus"></span> Add New Campaign</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="show('edit-project')" class="button info"><span class="mif-pencil"></span> Edit Project</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="deleteProject()" class="button alert"><span class="icon fa fa-trash"></span> Delete Project</button>
    </a>
</div>