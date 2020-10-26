<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    private const ROUTE_INDEX = 'index';

    /** @test */
    public function index_view_is_displayed()
    {
        // hit the index page
        $response = $this->get(route(self::ROUTE_INDEX));

        // assert that a 200 status is received.
        // assert that SWAPI and Tasks are displayed on the page.
        $response->assertStatus(200)
                 ->assertSee('SWAPI')
                 ->assertSee('Tasks');
    }
}
