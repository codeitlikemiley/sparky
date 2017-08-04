<!-- EDIT LOGO -->
<a class="navbar-brand" href="{{ config('nav.home') }}">
        @isset(request()->username->username)
        <img src="{{ request()->username->username . config('app.domain').'/img/logo.png' }}" class="logo" style="height: 50px;width:175px;">
        @endisset
        @empty(request()->username->username)
        <img src="{{ config('app.url').'/img/logo.png' }}" class="logo" style="height: 50px;width:175px;">
        @endempty
</a>

