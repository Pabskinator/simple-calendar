<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EventHelper
{

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

    public function extractDaysWithinAMonth($months)
    {
        $month_and_dates = [];
        $all_dates = [];

        foreach ($months as $month){
            $startDate = Carbon::parse($month)->startOfMonth();
            $endDate = Carbon::parse($month)->endOfMonth();

            while ($startDate->lessThanOrEqualTo($endDate)){
                $all_dates[] = $startDate->format('d D');
                $startDate->addDay();
            }

            $month_and_dates[$month] = $all_dates;
            $all_dates = [];
        }

        return $month_and_dates;
    }

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
