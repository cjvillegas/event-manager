<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
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
    
	/**
	 * Store new event entry into the database
	 *
	 * @param $request <Request>
	 *
	 * @return <array>
	 */
    public function store(Request $request)
    {
    	$attributes['event_name'] = $request->input('event_name');
    	$attributes['event_start'] = __asia_timezone_to_utc($request->input('event_start'));
    	$attributes['event_end'] = __asia_timezone_to_utc($request->input('event_end'));
    	$attributes['included_days'] = json_encode($request->input('included_days'));

    	\DB::beginTransaction();
        try {
        	$event = new Event;
    		$event->fill($attributes);
            $event->user_id = auth()->user()->id;
    		$event->created_at = __utc_time_now()->format('Y-m-d H:i:s');

    		if (!$event->validate()) {
    			return ['success' => false, 'errors' => $event->errors];
    		}

    		$event->save();

    		\DB::commit();

    		return ['success' => true];
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
	 * Fetch list of events.
	 *
	 * @param $request <Request>
	 *
	 * @return <array>
     */
    public function fetchEvent(Request $request)
    {
        $daterange = $request->input('daterange');

        __set_manila_timezone();
        
        $events = Event::select(
            'events.*',
            \DB::raw('DATE_FORMAT(CONVERT_TZ(event_start, "+00:00", "' . date('P') . '"), "%Y-%m-%d") AS event_start'),
            \DB::raw('DATE_FORMAT(CONVERT_TZ(event_end, "+00:00", "' . date('P') . '"), "%Y-%m-%d") AS event_end'),
            \DB::raw('DATE_FORMAT(CONVERT_TZ(created_at, "+00:00", "' . date('P') . '"), "%Y-%m-%d") AS created_at')
        );

        if ($daterange && is_array($daterange)) {
            $dates = ['start' => $daterange[0], 'end' => $daterange[1]];
            $events->betweenDates($dates);
        }

        $events = $events->get()->toArray();

        return ['success' => true, 'data' => $events];
    }
}
