@extends('evolutly::layouts.app') 

@push('critical_css')
<style>
    .demo-grid .row > .cell {
    background-color: #002933;
}
</style>
@endpush

@section('content')
<dashboard :user="user" :projects="projects" inline-template>
<div> 
    <div class="section-wrapper page-heading ">
        <h3>Welcome @{{ user.name }}</h3>
    </div>
    <div class="section-wrapper bg-white align-center">
        <h1>Overall Progress</h1>
    </div>

<div class="section-wrapper animated fadeInRightBig">
        <div class="grid condensed demo-grid">
                <div class="row cells3" v-for="item in projectChunks">
                    <div class="cell" v-for="project in item">
                        <div class="panel error">
                            <div class="heading">
                                <span class="title">@{{ project.name }}</span>
                            </div>
                            <div class="content">
                                <div class="tile-container row cells2">
                                    <div class="tile bg-amber fg-white cell" data-role="tile" @click="viewProject(project.id)">
                                        <div class="tile-content iconic cell">
                                            <span class="icon fa fa-flag"></span>
                                            <span class="tile-badge bg-lightOrange" style="margin-right: -14px; margin-bottom: 2px;">5</span>
                                            <span class="tile-label">Campaigns</span>
                                        </div>
                                    </div>
                                    
                                    <div class="tile bg-teal fg-white cell element-selected" data-role="tile" @click="viewProgress(project.id)">
                                        <div class="tile-content iconic cell">
                                            <span class="icon fa fa-tasks"></span>
                                            <div class="tile-label">Progress</div>
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
</dashboard>
@endsection