<?php
// URL format username.domain.com/client
Route::get('/', function($username){
    return 'Client Page with Tenants As : '.$username;
});



