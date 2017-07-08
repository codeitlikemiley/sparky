@extends('evolutly::layouts.app') 

@push('critical_css')
@include('css::footer')
@include('css::formbuilder')
@endpush

@push('header_js')

@endpush

@section('content')
<projects :tenant="{{ json_encode($tenant) }}" :user="user" :project="{{ json_encode($project) }}" :campaigns="{{ json_encode($project['campaigns']) }}" :workers="{{ json_encode($project['assigned_employees']) }}" inline-template>

<div class="section-wrapper animated fadeInRightBig">
    <br>
    <div class="panel widget-box">
        <div class="content">
            <div class="text">

                <h1 v-show="project.name">@{{project.name}}</h1>
                <hr>
                <div>
                    <a href="javascript:void(0);" onclick="alert('Please Create A Component to Add New Campaign');">
                    <button class="button info"><span class="mif-plus"></span> Add New Campaign</button>
                    </a>
                    <a href="javascript:void(0);" onclick="alert('Please Create A Component to Import Campaign');">
                    <button class="button info"><span class="mif-flag"></span> Campaign Options</button>
                    </a>
                    <a href="javascript:void(0);" onclick="alert('Please Create A Component to Edit Project');">
                    <button class="button info"><span class="mif-pencil"></span> Edit Project</button>
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
                                <div class="frames bg-grayLight">
                                    <div class="frame" id="tasks_tab">
                                        <div class="panel widget-box bg-grayLight" v-show="campaignChunks">

                                            <div class="row cells2 bg-grayLight" v-for="(chunk, index) in campaignChunks" :key="chunk.id" :index="index" :chunk="chunk">
                                                <div class="cell" v-for="(campaign, index) in chunk" :key="campaign.id" :index="index" :campaign="campaign">

                                                    <div class="panel">
                                                        <div class="heading align-center">
                                                            <span>@{{ campaign.name }}</span>
                                                        </div>
                                                        <div class="content">
                                                            <div class="listview set-border padding10" data-role="listview">

                                                                <div class="list-group">
                                                                    <div class="list-group-content">
                                                                        <div class="list" v-for="(task, index) in campaign.tasks" :key="task.id" :index="index" :task="task">
                                                                            <span>
                                                                            <span class="mif-clipboard fg-teal"></span>
                                                                            </span>
                                                                            <span class="fg-amber">@{{ task.progress }}</span>
                                                                            <strong class="fg-teal">/</strong>
                                                                            <span class="fg-green">@{{ task.total}}</span>
                                                                            </span>
                                                                            <span class="fg-teal">@{{ task.name }}</span>
                                                                            <a href="javascript:void(0);" onclick="alert('Please Create A Component to View task');">
                                                                        <span style="float: right;">
                                                                            <span class="icon fa fa-tasks fg-lightBlue"></span>
                                                                        </span>
                                                                        </a>
                                                                        </div>
                                                                        <div style="padding-left:50px;">
                                                                            <a href="javascript:void(0);" onclick="alert('Please Create A Component to Add Task');"> 
                                                                        <button class="button info">Add New Task</button>
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
                                    <div class="frame" id="onboarding_tab">
                                        @include('form::builder')
                                    </div>
                                    <div class="frame" id="files_tab">
                                        <div class="cell">
                                            <div style="height: 100px;">
                                                <!-- Add View Here to List All Assigned Employee in a Task -->

                                            </div>
                                            <div class="input-control file full-size" data-role="input">
                                                <input type="file" style="z-index: 0;" tabindex="-1">
                                                <input type="text" class="input-file-wrapper" readonly="" style="z-index: 1; cursor: default;display:none;">
                                                <button class="button" type="button"><span class="mif-folder"></span></button>
                                            </div>
                                            <div class="align-right">
                                                <a href="javascript:void(0);" onclick="alert('Please Create Upload A File Component');">
                                            <button class="button info"><span class="mif-upload"></span> Upload</button>
                                            </a>
                                            </div>
                                            <div style="height: 100px;">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="frame bg-white" id="people_tab" v-show="employeeChunks">
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

</div>


</projects>
@endsection

@push('footer_js')

@endpush