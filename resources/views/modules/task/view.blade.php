@extends('evolutly::layouts.app') 
@push('critical_css')
@include('css::footer')
@include('css::progressbar')
@endpush 
@section('content')
<!-- Section Wrapper -->
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
                        <div class="row">
                            @include('activity::logs')
                        </div>
                        <!-- Comments -->
                        <row class="row">
                            @include('comment::box')
                        </row>
                    </div>
                </div>
                <!-- Grid -->
            </div>
            <!-- Div text -->
        </div>
        <!-- Content -->
    </div>
    <!-- Panel box -->

</div>
<!-- Section Wrapper -->
@endsection