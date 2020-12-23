<?php

namespace Database\Factories;

use App\Helpers\EventHelper;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Collection;

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
     * Store dates on db
     *
     * @param array|null $dateRange
     * @param array|null $days
     * @return Collection
     */
    public function createEvents(array $dateRange = null, array $days = null)
    {
        return $this->createMany((new EventHelper())->getEvents($dateRange, $days, $this->faker->catchPhrase));
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
