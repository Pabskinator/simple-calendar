<?php

namespace Tests\Unit;

use App\Models\Event;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_create_events()
    {
        $this->withoutExceptionHandling();

        $dateRange = $this->generateSampleDateRange();
        $days = $this->generateSampleDays();

        // generate list of events
        $events = (new EventFactory())->getEvents($dateRange, $days);

        // make a post request to a route to create events
        $this->post(route('events.store'), $events)
            ->assertStatus(200);

        // check if the events are saved
        $created_events = Event::all();
        $this->assertCount(4, $created_events);
    }

    /** @test */
    public function it_saves_all_the_selected_days_within_the_date_range()
    {
        $dateRange = $this->generateSampleDateRange();
        $days = $this->generateSampleDays();

        $created_events = (new EventFactory())->createEvents($dateRange, $days);

        $events = Event::select('date')->get()->pluck('date')->toArray();

        $this->assertEquals(collect($created_events)->pluck('date')->toArray(), $events);

    }

//    /** @test */
//    public function it_fetches_the_correct_dates()
//    {
//        $this->withoutExceptionHandling();
//
//        $dateRange = $this->generateSampleDateRange();
//        $days = $this->generateSampleDays();
//
//        // generate events in database
//
//        $events = (new EventFactory())->createEvents($dateRange, $days);
//
//        $response = $this->get(route('events.index'));
//
//        $response->dumpHeaders();
//    }

    protected function generateSampleDateRange()
    {
        return [
            'fromDate' => '2020-12-01',
            'toDate' => '2020-12-31'
        ];
    }

    protected function generateSampleDays()
    {
        return [1];
    }
}
