<div class="content">
    <div class="text">
        @include('project::action_buttons')
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="tabcontrol" data-role="tabcontrol">
                    <ul class="tabs">
                        <li><a href="#tasks_tab">Tasks</a></li>
                        <li><a href="#onboarding_tab">Onboarding</a></li>
                        <li><a href="#files_tab">Files</a></li>
                        <li><a href="#people_tab">People</a></li>
                    </ul>
                    <div class="frames bg-white">
                        @include('task::tab')
                        @include('form::tab')
                        @include('file::tab')
                        @include('employee::tab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>