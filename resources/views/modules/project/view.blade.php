@extends('evolutly::layouts.app') 
@push('critical_css')
<style>
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        z-index: 5;
    }
#formbuilder_property{
    z-index: 10;
}
#form_layout {position: relative;}	
.fluent-menu .input-control {margin:3px 0;line-height: 1.5rem;height: 1.5rem;}
.fluent-menu .active-button {background-color: #BCDDFA;}
.color-box {border:1px solid #000;width: 1.25rem;height:1rem;float: left;margin:1px;}
#zen_input {height: 85px;min-height: 85px;width: 200px;}
#zen_output {height: 85px;min-height: 85px;width: 500px;}
.sub-class .d-menu {width: 15.625rem;}
.dropdown-wrap {position: relative;}
.fluent-menu .input-control.text button.button {height:1.5rem;padding:0.25rem 0.375rem;line-height: 0.8rem; }
.fluent-menu .tabs-content {z-index: 0;}

.popover {border:1px solid rgba(0,0,0,0.6);}
.popover:before {border-left: 1px solid rgba(0,0,0,0.6);border-bottom: 1px solid rgba(0,0,0,0.6);}
#formbuilder_property label {text-transform: capitalize;}
#formbuilder_property h4:first-child {margin-top:0;font-weight: bold;border-bottom: 1px solid #bbb;box-shadow: 0px 1px 0px #fff;padding-bottom:8px;}

</style>
@endpush 
@section('content')
<div class="section-wrapper animated fadeInRightBig">
    <br>
    <div class="panel widget-box">
        <div class="content">
            <div class="text">

                <h1>{{$project->name}}</h1>
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
                                        <div class="panel widget-box bg-grayLight">
                                        @foreach($project->campaigns->chunk(2) as $chunk)
                                            
                                            <div class="row cells2 bg-grayLight">
                                            @foreach($chunk as $campaign)
                                            <div class="cell">

                                                <div class="panel">
                                                    <div class="heading align-center">
                                                        <span>{{ $campaign->name }}</span>
                                                    </div>
                                                    <div class="content">
                                                        <div class="listview set-border padding10" data-role="listview">
                                                    
                                                            <div class="list-group">
                                                                    <div class="list-group-content">
                                                                        @foreach($campaign->tasks as $task)
                                                                        <div class="list">
                                                                        <span>
                                                                            <span class="mif-clipboard fg-teal"></span>
                                                                        </span> 
                                                                        <span class="fg-amber">{{ $task->progress }}</span>
                                                                        <strong class="fg-teal">/</strong>
                                                                        <span
                                                                            class="fg-green">{{ $task->total}}</span>
                                                                        </span> 
                                                                        <span class="fg-teal">{{ $task->name }}</span>
                                                                        <a href="javascript:void(0);" onclick="alert('Please Create A Component to View task');">
                                                                        <span style="float: right;">
                                                                            <span class="icon fa fa-tasks fg-lightBlue"></span>
                                                                        </span>
                                                                        </a>
                                                                        </div>
                                                                        @endforeach
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
                                            @endforeach
                                            </div>
                                         @endforeach

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
                                                <input type="text" class="input-file-wrapper"
                                                    readonly="" style="z-index: 1; cursor: default;display:none;">
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
                                    <div class="frame bg-white" id="people_tab">
                                         @foreach($project->assignedEmployees->chunk(4) as $employeeChunk) 
                                        <div class="row cells4">
                                        @foreach($employeeChunk as $employee)
                                        <div class="cell">
                                        <a href="javascript:void(0);" onclick="alert('Please Create Show User Profile Component');">
                                        <img src="{{ $employee->photo_url }}" 
                                            alt="{{ $employee->name }}"
                                            style="border: 2px solid #d3e0e9;
                                                    border-radius: 50%;
                                                    height: 40px;
                                                    padding: 2px;
                                                    width: 40px;
                                                    height: 50px;
                                                    width: 50px;"
                                        >
                                        {{ $employee->name }}
                                        </a>
                                        </div>
                                         @endforeach
                                        </div>
                                        
        
        
                                         @endforeach
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
@endsection