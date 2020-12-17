<?php

Route::get('/calendar', 'CalendarController@calendar')->name('calendar');
Route::get('/calendar-modified', 'CalendarController@calendarModified')->name('calendar-modified');
