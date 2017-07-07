<modal name="add-project">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Create New Project <span @click="hide('add-project')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                <div class="input-control text full-size">
                    @if($guard === 'employee')
                    <form method="POST" action="{{ route('employee.projects.create',['username' => $tenant->username]) }}">
                         {{ csrf_field() }}
                        <input  type="text" placeholder="Type Project Name" name="project_name">
                        <input type="hidden" placeholder="Type Project Name" name="client_id" value="1">
                        <button type="submit" class="button info">
                                <span class="icon mif-keyboard-return"></span>
                        </button>
                    </form>
                    @elseif($guard === 'client')
                    <form method="POST" action="{{ route('client.projects.create',['username' => $tenant->username]) }}">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Type Project Name" name="project_name">
                        
                        <button type="submit" class="button info">
                                <span class="icon mif-keyboard-return"></span>
                        </button>
                    </form>
                    @elseif(isset($request->username) && $guard === 'web')
                    <form method="POST" action="{{ route('tenant.projects.create',['username' => $tenant->username]) }}">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Type Project Name" name="project_name">

                        <button type="submit" class="button info">
                                <span class="icon mif-keyboard-return"></span>
                        </button>
                    </form>
                    @else
                    <form method="POST" action="/dashboard/projects/create">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Type Project Name" name="project_name">
                        
                        <button type="submit" class="button info">
                                <span class="icon mif-keyboard-return"></span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</modal>