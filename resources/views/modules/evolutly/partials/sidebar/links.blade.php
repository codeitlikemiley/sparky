@if($guard === 'employee')
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">
    <!-- First Menu Link -->
    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	    </a>
    <!-- First Menu Sub Links -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='projects'?'active':'') }}">
            <a href="{{ url('#') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Third Menu Link -->
<li class="{{  (in_array(Request::segment(1),['users','groups'])?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
        </a>
    <!-- Third Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(1),['users','groups'])?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ url('/settings#/profile') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
                </a>
        </li>
    </ul>
</li>
<!-- Sixth Menu Link -->
<li class="{{ (Request::segment(2)=='gallery'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-images icon fg-lightOrange"></span>
            <span class="title fg-amber">Uploads</span>
            <span class="counter">Manage Uploads</span>
        </a>
    <!-- Sixth Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='gallery'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='gallery2'?'active':'') }}">
            <a href="{{ url('admin/gallery/gallery2')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">File Management</span>
                    <span class="counter">Manage Files</span>
                </a>
        </li>
        <li class="{{ (Request::segment(3)=='gallery4'?'active':'') }}">
            <a href="{{url('admin/gallery/dropzone')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Upload Files</span>
                    <span class="counter">Drag n Drop file upload</span>
                </a>
        </li>
    </ul>
</li>
@elseif($guard === 'client')
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">
    <!-- First Menu Link -->
    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	    </a>
    <!-- First Menu Sub Links -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='projects'?'active':'') }}">
            <a href="{{ url('#') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Projects</span>
                <span class="counter">View Projects</span>
			</a>
        </li>
        <li class="{{ (Request::segment(3)=='projects'?'active':'') }}">
            <a href="{{ url('#') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Task</span>
                <span class="counter">View Tasks</span>
			</a>
        </li>
    </ul>
</li>
@else
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">
    <!-- First Menu Link -->
    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	    </a>
    <!-- First Menu Sub Links -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='projects'?'active':'') }}">
            <a href="{{ url('#') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Third Menu Link -->
<li class="{{  (in_array(Request::segment(1),['users','groups'])?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
        </a>
    <!-- Third Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(1),['users','groups'])?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ url('/settings#/profile') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
                </a>
        </li>
    </ul>
</li>
<!-- Fifth Menu Link -->
<li class="{{ (Request::segment(2)=='uicomponent'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-users icon fg-olive"></span>
            <span class="title fg-amber">User Management</span>
            <span class="counter">Manage Users</span>
        </a>
    <!-- Fifth Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='uicomponent'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='workers'?'active':'') }}">
            <a href="{{url('#')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Worker</span>
                    <span class="counter">Manage Worker</span>
                </a>
        </li>
        <li class="{{ (Request::segment(3)=='clients'?'active':'') }}">
            <a href="{{url('#')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Client</span>
                    <span class="counter">Manage Client</span>
                </a>
        </li>
    </ul>
</li>
<!-- Sixth Menu Link -->
<li class="{{ (Request::segment(2)=='gallery'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-images icon fg-lightOrange"></span>
            <span class="title fg-amber">Uploads</span>
            <span class="counter">Manage Uploads</span>
        </a>
    <!-- Sixth Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='gallery'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='gallery2'?'active':'') }}">
            <a href="{{ url('admin/gallery/gallery2')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">File Management</span>
                    <span class="counter">Manage Files</span>
                </a>
        </li>
        <li class="{{ (Request::segment(3)=='gallery4'?'active':'') }}">
            <a href="{{url('admin/gallery/dropzone')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Upload Files</span>
                    <span class="counter">Drag n Drop file upload</span>
                </a>
        </li>
    </ul>
</li>
@endif

<!-- Seventh Menu Link -->
<li class="{{ (Request::segment(2)=='chart'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
        <span class="mif-school icon fg-lighterBlue"></span>
        <span class="title fg-amber">Tutorial</span>
        <span class="counter">Watch Video</span>
	</a>
    <!-- Seventh Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='chart'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='getting-started'?'active':'') }}">
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Getting Started</span>
                <span class="counter">How To Get Started</span>
			</a>
        </li>
    </ul>
</li>
<!-- Eight Menu Link -->
<li class="">
    <a href="#" class="dropdown-toggle">
        <span class="mif-info icon fg-lightTeal"></span>
        <span class="title fg-amber">About</span>
        <span class="counter">Company Info</span>
	</a>
    <!-- Eight Menu SubLink -->
    <ul class="d-menu" data-role="dropdown">
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Change Log</span>
                <span class="counter">Read Our Updates</span>
			</a>
        </li>
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">TOS</span>
                <span class="counter">Read Our TOS</span>
			</a>
        </li>
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Disclaimer</span>
                <span class="counter">Read Disclaimer</span>
			</a>
        </li>
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Anti-Spam Policy</span>
                <span class="counter">Read Spam Policy</span>
			</a>
        </li>
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Legalities</span>
                <span class="counter">View Legalities</span>
			</a>
        </li>
    </ul>
</li>
<!-- Ninth Menu Link -->
<li>
    <a href="#support" class="">
        <span class="mif-help icon fg-darkOrange"></span>
        <span class="title fg-amber">Help</span>
        <span class="counter">Ask Support</span>
	</a>
</li>
<!-- Tenth Menu Link -->
<li>
    <a class="sidebar-sizer">
        <span class="mif-tab icon fg-grayLighter mif-ani-horizontal mif-ani-slow " ></span>
        <span class="title" >Collapse Sidebar</span>
        <span class="counter" >Toggle Small - Wide</span>
	</a>
</li>