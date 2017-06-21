@extends('layouts.front') 
@section('content')
<div class="page-container" style="height:100%;">
    <div class="container">
        <div class="grid no-margin-top">
            <div class="row cells align-center padding-top-90">
                <div class="cell fg-white text-shadow ">
                    <div class="leader">Evolutly</div>
                    <div class="header">"Easy Task Management"</div>
                </div>
            </div>
            <div class="row cells3 align-center padding-top-50">
                <div class="cell bg-red padding10">
                    <a href="#!" class="leader fg-white"><span class="mif-books"></span><br>Tutorials</a>
                </div>
                <div class="cell bg-yellow padding10">
                    <a href="{{ route('register') }}" class="leader fg-white"><span class="mif-user-plus"></span><br>Register</a>
                </div>
                <div class="cell bg-green padding10">
                    <a href="{{ route('login') }}" class="leader fg-white"><span class="fa fa-sign-in"></span><br>Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection