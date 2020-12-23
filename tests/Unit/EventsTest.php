<?php

namespace Tests\Unit;

use App\Helpers\EventHelper;
use App\Models\Event;
use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\Collection;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_create_events()
    {
        $this->withoutExceptionHandling();

        // make a post request to a route to create events
        $this->post(route('events.store'), [
            'name' => $this->faker->catchPhrase,
            'from' => '2020-11-01',
            'to' => '2020-12-31',
            'days' => $this->generateSampleDays()
        ])
        ->assertStatus(200);

        // check if the events are saved
        $created_events = Event::all();
        $this->assertCount(9, $created_events);
    }

    /** @test */
    public function it_saves_all_the_selected_days_within_the_date_range()
    {
        $created_events = $this->createEvents();

        $events = Event::select('date')->get()->pluck('date')->toArray();

        $this->assertEquals(collect($created_events)->pluck('date')->toArray(), $events);

    }

    /** @test */
    public function it_displays_the_correct_months()
    {
        $dates = collect($this->getEvents());

        $months =(new EventHelper())->extractMonthsWithinDates($dates);

        $this->assertEquals(['Nov 2020', 'Dec 2020'], $months);
        $this->assertCount(2, $months);
    }

    /** @test */
    public function it_checks_if_it_displays_all_the_days_within_the_months()
    {
        $dates = collect($this->getEvents());

        $months =(new EventHelper())->extractMonthsWithinDates($dates);

        $all_dates = (new EventHelper())->extractDaysWithinAMonth($months, $dates);

        $this->assertCount(Carbon::parse($months[0])->daysInMonth, $all_dates[0]->dates);
        $this->assertCount(Carbon::parse($months[1])->daysInMonth, $all_dates[1]->dates);
    }

    /** @test */
    public function it_deactivates_older_events_before_creating_new_events()
    {
        $this->createEvents();

        $this->assertDatabaseHas('events', [
            'active' => 1,
        ]);

        Event::closeOldEvents();

        $this->assertDatabaseMissing('events', [
            'active' => 1,
        ]);
    }

    /** @test */
    public function it_fetches_the_correct_dates()
    {
        $this->withoutExceptionHandling();

        $dateRange = $this->generateSampleDateRange();
        $days = $this->generateSampleDays();

        // generate events in database
        $events = (new EventFactory())->createEvents($dateRange, $days);

        $response = $this->get(route('events.index'));

        // check if all events are active
        $this->assertEquals(9, collect($response['events'])->groupBy('active')->map->count()[1]);

        // check if all stored events are present in response
        $stored_dates_array = collect(collect($events)->toArray())->pluck('date');
        $response_dates_array = collect($response['events'])->pluck('date');

        $this->assertEquals($stored_dates_array, $response_dates_array);

        //check if all the event name is equal
        $this->assertEquals(1, collect($response['events'])->groupBy('name')->count());
    }

    /** @test */
    public function it_throws_an_error_when_event_name_is_missing()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'))
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function it_throws_an_error_when_event_from_date_is_missing()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'))
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['from']]);
    }

    /** @test */
    public function it_throws_an_error_when_to_date_is_missing()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'))
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['to']]);
    }

    /** @test */
    public function it_throws_an_error_when_event_days_is_missing()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'))
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['days']]);
    }

    /** @test */
    public function it_throws_an_error_when_event_to_date_is_not_a_valid_date()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'), [
            'to' => 'sample string'
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['to']]);
    }

    /** @test */
    public function it_throws_an_error_when_event_from_date_is_not_a_valid_date()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'), [
            'from' => 'sample string'
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['from']]);
    }

    /** @test */
    public function it_throws_an_error_when_selected_days_is_not_an_array()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'), [
            'days' => 'sample string'
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['days']]);
    }

    /** @test */
    public function it_throws_an_error_when_selected_to_date_is_less_than_from_date()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'), [
            'to' => '2020-11-01',
            'from' => '2020-12-01',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['to']]);
    }

    /** @test */
    public function it_throws_an_error_if_no_events_can_be_stored()
    {
        $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'accept' => 'application/json'
        ])
        ->post(route('events.store'), [
            'to' => '2020-12-03',
            'from' => '2020-12-01',
            'days' => [1],
            'name' => $this->faker->catchPhrase
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['errors' => ['events']]);
    }

    /**
     * Use this to generate sample date range
     *
     * @return array
     */
    protected function generateSampleDateRange()
    {
        return [
            'fromDate' => '2020-11-01',
            'toDate' => '2020-12-31'
        ];
    }

    /**
     * Use this to generate sample days (0-6) sun to sat
     *
     * @return array
     */
    protected function generateSampleDays()
    {
        return [1];
    }

    /**
     * Use this to generate sample events
     *
     * @return array
     */
    protected function getEvents()
    {
        $dateRange = $this->generateSampleDateRange();
        $days = $this->generateSampleDays();

        return (new EventHelper())->getEvents($dateRange, $days, $this->faker->catchPhrase);
    }

    /**
     * Use this to create events
     *
     * @return Collection
     */
    protected function createEvents()
    {
        $dateRange = $this->generateSampleDateRange();
        $days = $this->generateSampleDays();

        return (new EventFactory())->createEvents($dateRange, $days);
    }
}
