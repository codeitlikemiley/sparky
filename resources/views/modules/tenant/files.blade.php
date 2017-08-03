@extends('evolutly::layouts.app')

@push('critical_css')
@include('css::footer')
@endpush

@section('content')
<file-management :tenant="tenant" :files="{{ json_encode($files) }}" inline-template>
<div>
    <div class="section-wrapper bg-grayLighter align-center">
        <h1>Files</h1>
    </div>
    
    <div class="section-wrapper animated fadeInRightBig">
        <div class="grid ">
            <div class="row cells3" v-for="item in fileChunks(files)">
                <div class="cell gallery" v-for="file in item">
                    <div class="image">
                        <div class="image-inner">
                            <a :href="getSourceFile(file)">
                                <img  :src="getImageByExtension(file)" alt="" />
                            </a>
                            <p class="image-caption">
                                @{{ file.name }}
                            </p>
                        </div>
                        <div class="image-info">
                            <h5 class="title">@{{ file.name }}</h5>
                            <div class="pull-right">
                                <small>Uploaded By:</small> <a style="cursor:pointer;">@{{ file.uploadable.name }}</a>
                            </div>
                            <div class="pull-left">
                                    <small>Project:</small> <a style="cursor:pointer;">@{{ file.project.name }}</a>
                                </div>
                            
                            <div class="desc">
                                BUtton here to Edit or Delete
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</file-management>
@endsection

@push('footer_js')

@endpush