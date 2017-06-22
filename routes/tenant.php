<?php 
// URL format username.domain.com/admin
Route::get('/', function($username){
    return 'Admin Page with Tenants As: ' .$username;
});
