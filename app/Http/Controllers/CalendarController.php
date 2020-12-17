<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function calendar()
    {
    	return view('calendar', []);
    }

    public function calendarModified()
    {
    	return view('calendar-modified', []);
    }
}
