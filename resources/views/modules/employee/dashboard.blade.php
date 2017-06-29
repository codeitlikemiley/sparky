@extends('evolutly::layouts.app') 
@section('content')
<dashboard :user="user" inline-template>

        <!-- Application Dashboard -->
        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        Your application's dashboard.
                    </div>
                </div>
            </div>
        </div>

</dashboard>
@endsection