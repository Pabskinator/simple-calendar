<?php

namespace App\Http\Controllers;

use App\Helpers\EventHelper;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('active', 1)->get();

        $months = (new EventHelper())->extractMonthsWithinDates($events);

        $months_and_days = (new EventHelper())->extractDaysWithinAMonth($months, $events);

        return compact('events', 'months_and_days');
    }

    public function store(Request $request)
    {
        $this->validateEvents($request);

        Event::closeOldEvents();

        $dateRange = [
            'fromDate' => $request->from,
            'toDate' => $request->to
        ];

        $events = (new EventHelper())->getEvents($dateRange, $request->days, $request->name);

        if(!$events){
            return response()->json(['errors'=>['days' => ['Selected day/s are not within the specified date range.']]], 422);
        }

        return Event::insert($events);
    }

    protected function validateEvents(Request $request)
    {
        $rules = [
            'name' => 'required',
            'from' => 'required|date',
            'days' => 'required|array',
            'to' => 'required|date|after_or_equal:.' . $request->from,
        ];

        $messages = [
            'name.required' => 'Name field is required.',
            'to.required' => 'Date to field is required.',
            'from.required' => 'Date from field is required.',
            'to.date' => 'The date to value must be a valid date',
            'from.date' => 'The date from value must be a valid date',
            'days.required' => 'You need to select at least one day for the event.',
            'to.after_or_equal' => "The date to value must be a date after or equal to " . $request->from . '.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();
    }

}
