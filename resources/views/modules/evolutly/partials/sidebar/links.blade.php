@if($guard === 'employee')
<!-- Dashboard Menu-->
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">

    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	</a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='dashboard'?'active':'') }}">
            <a href="{{ route('employee.dashboard',['username' => $tenant->username]) }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Profile Menu -->
<li class="{{ (Request::segment(2)=='profile'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
    </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='profile'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ route('employee.profile',['username' => $tenant->username]) }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
            </a>
        </li>
    </ul>
</li>
<!-- File Menu -->
<li class="{{ (Request::segment(2)=='files'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-file-upload icon fg-lightOrange"></span>
            <span class="title fg-amber">Files</span>
            <span class="counter">Manage Uploads</span>
        </a>
    <!-- File Links -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='gallery'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='files'?'active':'') }}">
            <a href="{{ url('/employee/files')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">File Management</span>
                    <span class="counter">Manage Files</span>
                </a>
        </li>
        <li class="{{ (Request::segment(3)=='upload'?'active':'') }}">
            <a href="{{url('/employee/files/upload')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Upload Files</span>
                    <span class="counter">Drag n Drop file upload</span>
                </a>
        </li>
    </ul>
</li>
@elseif($guard === 'client')
<!-- Dashboard Menu -->
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">

    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	</a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='dashboard'?'active':'') }}">
            <a href="{{ route('client.dashboard',['username' => $tenant->username]) }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Profile Menu -->
<li class="{{ (Request::segment(2)=='profile'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
    </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='profile'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ route('client.profile',['username' => $tenant->username]) }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
            </a>
        </li>
    </ul>
</li>
@else
<!-- Dashboard Menu -->
<li class="{{ (Request::segment(1)=='dashboard'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	    </a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(1)=='dashboard'?'active':'') }}">
            <a href="/dashboard">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Profile Menu -->
<li class="">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
        </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="">
        <li class="">
            <a href="{{ url('/settings#/profile') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
                </a>
        </li>
    </ul>
</li>
<!-- Users Menu Link -->
<li class="{{ (Request::segment(1)=='users'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-users icon fg-olive"></span>
            <span class="title fg-amber">User Management</span>
            <span class="counter">Manage Users</span>
        </a>
    
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(2),['employee','client'])?'display:block':'') }}">
        <!-- Employee -->
        <li class="{{ (Request::segment(2)=='employee'?'active':'') }}">
            <a href="{{url('/users/employee')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Worker</span>
                    <span class="counter">Manage Worker</span>
                </a>
        </li>
        <!-- Client -->
        <li class="{{ (Request::segment(2)=='client'?'active':'') }}">
            <a href="{{url('/users/client')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Client</span>
                    <span class="counter">Manage Client</span>
                </a>
        </li>
    </ul>
</li>
<!-- File Menu -->
<li class="{{ (Request::segment(1)=='files'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-images icon fg-lightOrange"></span>
            <span class="title fg-amber">Uploads</span>
            <span class="counter">Manage Uploads</span>
        </a>
    <!-- Sixth Menu SubLink -->
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(2),['/','upload'])?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='/'?'active':'') }}">
            <a href="/files" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">File Management</span>
                    <span class="counter">Manage Files</span>
                </a>
        </li>
        <li class="{{ (Request::segment(2)=='upload'?'active':'') }}">
            <a href="/files/upload" class="">
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