@extends('evolutly::layouts.app')

@push('critical_css')
@include('css::footer')
@include('css::progressbar')
@endpush

@section('content')

<div class="section-wrapper page-heading ">
    <h3> Progress of {{ $project->name }}</h3>
    @if($guard === 'employee')
    <a href="/employee/dashboard" class="button info margin10"><span class="icon fa fa-caret-left"></span> Back</a>
    @elseif($guard === 'client')
    <a href="/client/dashboard" class="button info margin10"><span class="icon fa fa-caret-left"></span> Back</a>
    @else 
    <a href="/dashboard" class="button info margin10"><span class="icon fa fa-caret-left"></span> Back</a>
    @endif
</div>

@foreach($campaigns as $campaign)
<div class="section-wrapper bg-white align-left">
    <h2>{{ $campaign['name'] }}</h2>
</div>

<div class="w3-container">
    <div class="w3-light-grey w3-xxlarge">
        <div class="w3-container w3-green" style="width: {{ $campaign['progress'] }}%">{{ $campaign['progress'] }}% </div>
    </div>
</div>

@endforeach
    


@endsection