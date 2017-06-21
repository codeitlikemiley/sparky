<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-gear"></span></div>
        <a href="#!" class="app-bar-element branding">
             {!!config('nav.brand.logo')!!}
             {!!config('nav.brand.title')!!}
        </a>
        <ul class="app-bar-menu place-right">
            @if (Auth::guest())
            @include('partials.header.guest_link')
            @else
            @include('partials.header.notification_latest')
            @include('partials.header.rtl')
            @include('partials.header.user_profile')
            @endif
        </ul>
    </div>
</div>