<a href="#!" class="app-bar-element branding bg-hover-red"> 
    @isset(request()->username->username)
    <img src="{{ config('app.url').'/img/logo.png' }}" class="logo" style="height: 50px;width:175px;">
    @endisset
    @empty(request()->username->username)
    <img src="{{ config('app.url').'/img/logo.png' }}" class="logo" style="height: 50px;width:175px;">
    @endempty
</a>