<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
        @include('partials.navbar.logo')
        <ul class="app-bar-menu place-right">
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="#!" data-role="hint" data-hint="Need Help?" data-hint-background="bg-darkTeal" data-hint-color="fg-white">&nbsp;<span class="mif-help fg-orange"></span> Support</a>
            </li>
            @if(isset(request()->username->username))
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{ route('client.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Are You A Client of {{$tenant->name}}?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="fa fa-user-secret fg-lime"></span>  Client</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{ route('employee.login',['username' => $tenant->username]) }}" data-role="hint" data-hint="Are You An Employee of {{$tenant->name}}?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="fa fa-suitcase fg-red"></span>  Employee</a>
            </li>
            @else
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="/login" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-enter fg-lime"></span>  Login</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="/register" data-role="hint" data-hint="Dont Have Any Account Yet?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-user-plus fg-teal "></span>  Register</a>
            </li>
            @endif
            
            
        </ul>
    </div>
</div>