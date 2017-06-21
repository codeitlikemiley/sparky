<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
        <a href="#!" class="app-bar-element branding bg-hover-red"> 
             {!!config('nav.brand.logo')!!}
             {!!config('nav.brand.title')!!}
        </a>

        <ul class="app-bar-menu place-right">
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="#!" data-role="hint" data-hint="Need Help?" data-hint-background="bg-darkTeal" data-hint-color="fg-white">&nbsp;<span class="mif-help fg-orange"></span> Support</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="/login" data-role="hint" data-hint="Already A Member?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-enter fg-lime"></span>  Login</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="/register" data-role="hint" data-hint="Dont Have Any Account Yet?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-user-plus fg-teal "></span>  Register</a>
            </li>
        </ul>
    </div>
</div>