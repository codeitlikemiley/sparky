@extends('evolutly::layouts.dashboard') 

@push('critical_css')
@include('css::footer')
@include('css::formbuilder')
@include('css::fraction')
@endpush

@push('header_js')

@endpush

@section('content')
<vue-up></vue-up>
<templates :guard="{{ json_encode($guard) }}" :templatelist="{{json_encode($templates)}}" :tenant="tenant" :user="user" inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <div class="grid">
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="panel widget-box">
                    @include('template::breadcrumbs')
                    @include('template::content')
                </div>
            </div>
        </div>
    </div>

</div>
</templates>
@endsection

@push('footer_js')

@endpush