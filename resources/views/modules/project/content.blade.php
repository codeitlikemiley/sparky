<div class="content">
    <div class="text">
        <div>
            <a href="#!">
                <button @click="show('add-campaign')" class="button info"><span class="mif-plus"></span> Add New Campaign</button>
            </a>
            <a href="#!">
                <button @click="show('edit-project')" class="button info"><span class="mif-pencil"></span> Edit Project</button>
            </a>
            <a href="#!">
                <button @click="deleteProject()" class="button alert"><span class="icon fa fa-trash"></span> Delete Project</button>
            </a>
        </div>
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="tabcontrol" data-role="tabcontrol">
                    <ul class="tabs">
                        <li><a href="#tasks_tab">Tasks</a></li>
                        <li><a href="#onboarding_tab">Onboarding</a></li>
                        <li><a href="#files_tab">Files</a></li>
                        <li><a href="#people_tab">People</a></li>
                    </ul>
                    <div class="frames bg-white">
                        @include('task::tab') @include('form::tab') @include('file::tab') @include('employee::tab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>