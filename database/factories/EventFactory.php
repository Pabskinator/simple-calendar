<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * Generate a list of events within two dates
     * with the specified days
     *
     * @param array|null $dateRange
     * @param array|null $days
     * @return array
     */
    public function getEvents(array $dateRange = null, array $days = null)
    {
        $dateRange = $dateRange ? $dateRange : $this->generateDateRange();
        $days = $days ? $days : $this->generateDays();

        $dateFrom = Carbon::parse($dateRange['fromDate']);
        $dateTo = Carbon::parse($dateRange['toDate']);
        $temp = $dateFrom;
        $dateList = [];
        $eventName = $this->faker->catchPhrase;
        $dayArray = (new Carbon())->getDays();

        foreach ($days as $day){
            while($temp->lessThanOrEqualTo($dateTo)) {

                $current = $temp;

                if($current->lessThanOrEqualTo($dateTo) && $current->dayOfWeek === $day) {
                    $dateList[] = [
                        'name' => $eventName,
                        'date' => $current->format('Y-m-d')
                    ];
                }

                $temp->next($dayArray[$day]);
            }
            $temp = Carbon::parse($dateRange['fromDate']);
        }

        return $dateList;
    }

    public function createEvents(array $dateRange = null, array $days = null)
    {
        return $this->createMany($this->getEvents($dateRange, $days));
    }

    /**
     * Generate date range
     *
     * @return array
     */
    public function generateDateRange()
    {
        $date = $this->faker->date();

        return [
            'fromDate' => $date,
            'toDate' => Carbon::parse($date)->addDays(rand(1, 30))->toDateString()
        ];
    }

    /**
     * Returns an array of numbers
     * between 0 (sunday) and 6 (saturday)
     *
     * @return array
     */
    public function generateDays()
    {
        $dayArray = range(0, 6);

         for($i = 1; $i <= rand(1,6); $i++){
            $randomKey = array_rand($dayArray, 1);
            unset($dayArray[$randomKey]);
        }

        return array_values($dayArray);
    }

}
