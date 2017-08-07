@extends('evolutly::layouts.dashboard')
@push('critical_css')
@include('css::grid')
@include('css::footer')
@endpush
@section('content')
<vue-up></vue-up>
<dashboard :guard="{{ json_encode($guard) }}" :tenant="tenant" :clients="clients" :user="user" :projects="projects" inline-template>
<div>
    <div class="section-wrapper page-heading">

        <div>
            <h2 class="place-left alight-left fg-amber">Welcome! @{{ user.name }}</h2>
        </div>

        <div class="place-right align-right" v-if="guard === 'web'" style="position:relative; top: 10px; right: 10px;">
            <a href="#!">
                <button @click="show('add-project')" class="button info"><span class="mif-plus"></span> Add New Project</button>
            </a>
        </div>

    </div>

    <div class="section-wrapper bg-grayLighter align-center" style="margin-top:100px;">
        <h1 v-show="projects.length >0">Assigned Projects</h1>
    </div>
        
    <div v-if="projects.length >0" class="section-wrapper animated fadeInRightBig margin-bottom-40">
        <div class="grid condensed demo-grid">
            <div class="row cells3" v-for="(chunk, index_chunk, key_chunk) in projectChunks(projects)" :chunk="chunk" :index="index_chunk" :key="key_chunk">
                <div class="cell" v-for="(project,index_project) in chunk" :project="project" :index="index_project" :key="project.id">
                    <div class="panel error">
                        <div class="heading">
                            <span class="title">@{{ project.name }}</span>
                                <span v-if="guard === 'web'" @click="deleteProject(index_project,project.id)" class="bg-red alert icon fa fa-trash"></span>
                        </div>
                        <div class="content">
                            <div class="tile-container row cells2">
                                <div class="tile bg-amber fg-white cell" data-role="tile" @click="viewProject(project.id)">
                                    <div class="tile-content iconic cell">
                                        <span class="icon fa fa-flag"></span>
                                        <span class="tile-badge bg-lightOrange" style="margin-right: -14px; margin-bottom: 2px;">@{{ project.campaigns_count }}</span>
                                        <span class="tile-label">Campaigns</span>
                                    </div>
                                </div>

                                <div class="tile bg-teal fg-white cell element-selected" data-role="tile" @click="viewProgress(project.id,project.slug)">
                                    <div class="tile-content iconic cell">
                                        <span class="icon fa fa-tasks"></span>
                                        <div class="tile-label">Progress</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @include('project::view-progress-modal')
                </div>
            </div>
            
        </div>
    </div>
    <div v-else class="align-center v-align-middle" style="min-height: 500px; padding-top:100px;" :class="styling">
        <h1 class="fg-teal">Create Your First Project.</h1>
    </div>
    @include('project::add-project-modal')
        
</div>
</dashboard>
@endsection