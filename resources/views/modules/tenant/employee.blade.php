@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer') 
<style>
.option-wrap {
    width: 110px;
}
.name-wrap {
    width: 220px;
}
.designation-wrap {
    width: 30%;
}
</style>
@endpush @section('content')
<employee-management :guard="{{ json_encode($guard) }}" :user="user">
</employee-management>
@endsection

@push('footer_js')

@endpush