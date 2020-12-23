<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EventHelper
{

    /**
     * Extracts the months within a given array of dates
     * Defaults to current month if dates are empty
     *
     * @param $dates
     * @return array|string
     */
    public function extractMonthsWithinDates($dates)
    {
        if($dates->isEmpty()){
            return [Carbon::now()->format("M Y")];
        }

        $sorted_dates = $dates->sortBy('date')->pluck('date')->values()->all();

        $from_date = reset($sorted_dates);
        $to_date = end($sorted_dates);

        $months = CarbonPeriod::create($from_date, '1 month', $to_date);
        $months_array = [];

        foreach ($months as $month) {
            $months_array[] = $month->format("M Y");
        }

        return $months_array;
    }

    /**
     * Extracts the dates within months
     * Assigns active event dates and names to dates
     *
     * @param $months
     * @param $events
     * @return array
     */
    public function extractDaysWithinAMonth($months, $events)
    {
        $month_and_dates = [];
        $all_dates = [];
        $event_dates = array_column($events->toArray(), 'date');
        $event_name = $events->groupBy('name')->keys()->first();


        foreach ($months as $month){
            $startDate = Carbon::parse($month)->startOfMonth();
            $endDate = Carbon::parse($month)->endOfMonth();

            while ($startDate->lessThanOrEqualTo($endDate)){
                if(in_array($startDate->toDateString(), $event_dates)){
                    $active = true;
                    $name = $event_name;
                }else{
                    $active = false;
                    $name = '';
                }

                $all_dates[] = (object) [
                    'name' => $name,
                    'active' => $active,
                    'date' => $startDate->format('d D'),
                ];

                $startDate->addDay();
            }

            $month_and_dates[] = (object) [
                'month_name' => $month,
                'dates' => $all_dates
            ];

            $all_dates = [];
        }

        return $month_and_dates;
    }

    /**
     * Generates sample events
     *
     * @param $dateRange
     * @param $days
     * @param $name
     * @return array
     */
    public function getEvents($dateRange, $days, $name)
    {
        $dateFrom = Carbon::parse($dateRange['fromDate']);
        $dateTo = Carbon::parse($dateRange['toDate']);
        $temp = $dateFrom;
        $dateList = [];
        $dayArray = (new Carbon())->getDays();

        foreach ($days as $day){
            while($temp->lessThanOrEqualTo($dateTo)) {

                $current = $temp;

                if($current->lessThanOrEqualTo($dateTo) && $current->dayOfWeek === $day) {
                    $dateList[] = [
                        'name' => $name,
                        'date' => $current->toDateString()
                    ];
                }

                $temp->next($dayArray[$day]);
            }
            $temp = Carbon::parse($dateRange['fromDate']);
        }

        return $dateList;
    }
}
