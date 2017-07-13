@extends('evolutly::layouts.app') 

@push('critical_css')
@include('css::footer')
@include('css::formbuilder')
@endpush

@push('header_js')

@endpush

@section('content')
<vue-up></vue-up>
<projects :guard="{{ json_encode($guard) }}" :clients="clients" :tenant="tenant" :user="user" :project="{{ json_encode($project) }}" :campaigns="{{ json_encode($campaigns) }}" :workers="{{ json_encode($workers) }}" inline-template>

<div class="section-wrapper animated fadeInRightBig">
    <br>
    <div class="panel widget-box">
        <div class="content">
            <div class="text">

                <h1 v-text="projectForm.project_name">
                </h1>
                <hr>
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
                <div class="grid responsive">
                    <div class="row cells1">
                        <div class="cell">

                            <div class="tabcontrol" data-role="tabcontrol">
                                <ul class="tabs">
                                    <li><a href="#tasks_tab">Tasks</a></li>
                                    <li><a href="#onboarding_tab">Onboarding</a></li>
                                    <li><a href="#files_tab">Files</a></li>
                                    <li><a href="#people_tab">People</a></li>
                                </ul>
                                <div class="frames bg-white">
                                    <div class="frame bg-white" id="tasks_tab">
                                        
                                        <div class="panel widget-box">

                                            <div class="row cells2" style="padding: 20px;background-color:#bbdefb;" v-for="(chunk, keyChunk) in campaignChunks(campaigns)" :key="keyChunk">
                                                <draggable class="cell draghandle" v-for="(campaign, cKey) in chunk" 
                                                :options="{group: 'campaign',handle: '.draghandle',filter: '.v--modal-box,.v--modal',scroll: true,preventOnFilter: false,}"
                                                 :data-id="campaign.id" :key="cKey"
                                                 @end="onEnd"
                                                 style="min-height: 150px;"
                                                 :leftOrRight="cKey" :max="keyChunk" :data-id="campaign.id"
                                                 >
                                                    <div class="panel">
                                                        
                                                        <div class="heading align-center bg-lightBlue" style="cursor:move;">
                                                            <span class="">@{{ campaign.name }}</span>
                                                            <span class="icon  fa fa-pencil-square-o bg-steel" @click="editCampaignModal(campaign)" style="cursor:pointer;"></span>
                                                            
                                                            <div @click="deleteCampaign(campaign)" class="bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;">
                                                                <i class="fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);" aria-hidden="true" ></i>
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <div class="listview set-border padding10" data-role="listview">

                                                                <div class="list-group">
                                                                    <div class="list-group-content">
                                                                        <div v-if="campaign.tasks.length > 0" class="list" @click="viewTask(task.id)" v-for="(task, index_task) in campaign.tasks">
                                                                            <span>
                                                                                <span class="mif-clipboard fg-teal">
                                                                                </span>
                                                                            </span>
                                                                            <span class="fg-amber">
                                                                                @{{ task.done_points }}
                                                                            </span>
                                                                            <strong class="fg-teal">/</strong>
                                                                            <span class="fg-green">@{{ task.total_points}}</span>
                                                                            <span class="fg-teal">@{{ task.name }}</span>
                                                                            <a href="#!">
                                                                                <span style="float: right;">
                                                                                    <span class="icon fa fa-tasks fg-lightBlue">
                                                                                    </span>
                                                                                </span>
                                                                             </a>
                                                                        </div>

                                                                        <div style="padding-left:50px;">
                                                                            <button @click="showTask(campaign.id)" class="button info">Add New Task</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </draggable>
                                                   @include('campaign::edit-campaign-modal')
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="frame" id="onboarding_tab">
                                        @include('form::builder')
                                    </div>

                                    <div class="frame" id="files_tab">
                                        <form @submit.prevent="uploadFile(project.id)" role="form" enctype="multipart/form-data">
                                        <div class="cell">
                                            <div style="height: 100px;">
                                                <!-- Add View Here to List All Assigned Employee in a Task -->
                                            </div>
                                            <div class="input-control file full-size" data-role="input">
                                                <input id="file" type="file" style="z-index: 0;" tabindex="-1">
                                                <input type="text" class="input-file-wrapper" readonly="" style="z-index: 1; cursor: default;display:none;">
                                                <button class="button" type="button"><span class="mif-folder"></span></button>
                                            </div>
                                            <div class="align-right">
                                                    <button type="submit" class="button info">
                                                        <span class="mif-upload">
                                                        </span> Upload
                                                    </button>
                                            </div>
                                            <div style="height: 100px;">

                                            </div>
                                        </div>
                                        </form>
                                    </div>

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

                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
<!-- ADD ALL MODALS HERE THAT IS NOT SPECIFIC FOR PROJECT OR CAMPAIGN -->
@include('project::edit-project-modal')
@include('campaign::add-campaign-modal')
<!-- Modal Specific For Creating Task -->
@include('task::add-task-modal')


</div>
</projects>
@endsection

@push('footer_js')

@endpush