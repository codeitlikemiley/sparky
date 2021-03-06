@extends('layouts.login') 
@push('critical_css')
<style>
    #minicalendar {
        position: fixed;
        bottom: 3rem;
        left: 2rem;
        color: #fff;
    }

    #clock {
        font-size: 90px;
        position: relative;
        top: -1rem;
    }


    .login-form {
        width: 18rem;
        height: auto;
        position: fixed;
        top: 0;
        bottom: 0px;
        right: -18rem;
        margin-left: -12.5rem;
        background-color: rgba(0, 0, 0, 0.45);
        opacity: 0;
        -webkit-transform: scale(.8);
        transform: scale(.8);
    }

    body {
        background-image: url('{{asset("images/lock/landscape/".$lock_images[rand(0,count($lock_images)-1)])}}');
        background-color: #1d1d1d;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
    }

    .avatar {
        /* fill the container, preserving aspect ratio, and cropping to fit */
        background-size: cover;

        /* center the image vertically and horizontally */
        background-position: center;

        /* round the edges to a circle with border radius 1/2 container size */
        border-radius: 50%;
    }
</style>
@endpush @section('content')
<div class="login-form padding20 fg-white ">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
        {{ csrf_field() }}
        <div class="align-center">
                <img src="{{ config('app.url').'/img/logo.png' }}" class="logo" style="height: 50px;width:175px;">
        </div>
        <br>
        <br>
        <div class="input-control text full-size" data-role="input">
            <label for="user_login">Email:</label>
            <input type="text" name="email" id="user_login" value="{{ old('email') }}">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
        <br />
        <br />
        <div class="form-actions">

            <button type="submit" class="button primary">Reset Password</button>
            <a href="{{url('/login')}}" type="button " class="button fg-white link "><span class="mif-blocked mif-ani-horizontal mif-ani-fast"></span> Cancel</a>
        </div>
    </form>
</div>

<div id="minicalendar">
    <h1 id="date"></h1>
    <h1 id="clock"></h1>
</div>
@endsection @push('footer_js')
<script language="javascript" type="text/javascript">
    var timer;
    jQuery(document).ready(function ($) {
        var form = $(".login-form");
        form.css({
            opacity: 1,
            right: 0,
            "-webkit-transform": "scale(1)",
            "transform": "scale(1)",
            "-webkit-transition": "1s",
            "transition": "1s"
        });
        var img_array = ['{!! implode("', '",$lock_images) !!}'],
            newIndex = 0,
            index = 0,
            interval = 15000;
        $(img_array).each(function (i, o) {
            loadImage = '{{asset("images/lock/landscape")}}\/' + o;
            $('<img src="' + loadImage + '" class="hide" >').appendTo('#login-page');
        })
        function changeBg() {

            index = (index % img_array.length) + 1;
            bgImage = 'url({{asset("images/lock/landscape")}}\/' + img_array[index - 1] + ')';
            $('body').css({
                'background-image': bgImage,
                '-webkit-transition': 'all 2s ease',
                '-moz-transition': 'all 2s ease',
                '-o-transition': 'all 2s ease',
                'transition': 'all 2s ease'
            });
        };
        setInterval(changeBg, interval);
        function clock() {
            $('#clock').html(moment().format('H:mm'));
            $('#date').html(moment().format('dddd<br>D MMMM'));
        }
        setInterval(clock, 1000);
    });

</script>
@endpush