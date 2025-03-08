<?php

// use Illuminate\Routing\Route;

function isActiveRoute($routeName)
{
    return \Illuminate\Support\Facades\Route::is($routeName);
}

function set_active($uri, $output = 'active')
{
 if( is_array($uri) ) {
   foreach ($uri as $u) {
     if (isActiveRoute($u)) {
       return $output;
     }
   }
 } else {
   if (isActiveRoute($uri)){
     return $output;
   }
 }
}