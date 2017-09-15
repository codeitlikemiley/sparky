@extends('evolutly::layouts.dashboard') 

@push('critical_css')
@include('css::footer')
@include('css::progressbar')
<link href="https://unpkg.com/trumbowyg@2.7.0/dist/ui/trumbowyg.min.css" rel="stylesheet">
@endpush 

@section('content')
<!-- Section Wrapper -->
<vue-up></vue-up>
<subtask :guard="{{json_encode($guard)}}" 
:current-project="{{json_encode($project)}}" 
:current-subtask="{{ json_encode($subtask) }}" 
:current-task="{{ json_encode($task) }}" 
:current-workers="{{ json_encode($workers) }}" 
:current-client="{{ json_encode($client) }}" 
:tenant="tenant" 
:user="user" 
inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <br>
    <!-- Panel box -->
    <div class="panel widget-box">
        <!-- Content -->
        <div class="content">
            @include('subtask::breadcrumbs')
            <!-- Div text -->
            <div class="text">
                
                <div class="row cells12">
                        <div class="tabcontrol" data-role="tabcontrol">
                            <ul class="tabs">
                                <li><a href="#view_tab">Task</a></li>
                                <li><a href="#edit_tab">Edit</a></li>
                                <li><a href="#people_tab">Team</a></li>
                                
                            </ul>
                            <div class="grid frames bg-white">
                                @include('subtask::data')
                                @include('subtask::edit')
                                @include('subtask::employee')
                            </div>
                        </div>
                </div>
            </div>
            <!-- Div text -->
        </div>
        <!-- Content -->
    </div>

    <!-- Panel box -->
</div>

<!-- Section Wrapper -->
</subtask>

@endsection