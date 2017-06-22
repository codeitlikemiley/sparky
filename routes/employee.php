<?php 
// URL format username.domain.com/employee
Route::get('/', function($username){
    return 'Employee Page with Tenants As: '. $username;
});