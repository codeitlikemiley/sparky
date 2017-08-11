@extends('evolutly::layouts.dashboard') 

@push('critical_css')
@include('css::footer')
@include('css::progressbar')
@endpush 

@section('content')
<!-- Section Wrapper -->
<vue-up></vue-up>
<task :guard="{{json_encode($guard)}}" :activities="{{json_encode($activities)}}" :campaign="{{ json_encode($campaign) }}" :client="{{json_encode($client)}}" :employees="employees" :tenant="tenant" :user="user" :task="{{json_encode($task)}}" :project="{{json_encode($project)}}" inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <br>
    <!-- Panel box -->
    <div class="panel widget-box">
        <!-- Content -->
        <div class="content">
            @include('task::breadcrumbs')
            <!-- Div text -->
            <div class="text">
                <!-- Header -->
                @include('task::data')
                <br>
                <br>
                <br>
                <hr>
                <!-- Header -->
                
                <!-- Grid -->
                <div class="grid">
                    <!-- Task Points -->
                    
                    <div class="row padding10">
                        @include('task::points')
                    </div>
                    
                    <div class="row">
                        <!-- Task Status -->
                        @include('task::progress')
                        
                    </div>
                   
                    <!-- Subtask table -->
                    
                    <div class="row">
                        @include('subtask::table')
                    </div>
                    <!-- Activity and Comment Section -->
                    <div class="row margin-bottom-90">
                        <!-- Activity -->
                        <div class="row" v-if="guard != 'client'">
                            @include('activity::logs')
                        </div>
                        <!-- Comments -->
                        <div class="row">
                            @include('comment::box')
                        </div>
                    </div>
                </div>
                <!-- Grid -->
            </div>
            <!-- Div text -->
        </div>
        <!-- Content -->
    </div>
    @include('task::edit-task-modal')
    @include('task::delete-task-modal')
    @include('subtask::add-subtask-modal')
    <!-- Panel box -->
</div>

<!-- Section Wrapper -->
</task>

@endsection