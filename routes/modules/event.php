<?php

Route::match(['post', 'get'], '/event/fetch-events', 'EventController@fetchEvent')->name('fetch-events');
Route::resource('event', 'EventController');