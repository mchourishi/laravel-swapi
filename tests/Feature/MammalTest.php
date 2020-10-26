<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MammalTest extends TestCase
{
    private const ROUTE_MAMMALS = 'species';

    /** @test */
    public function mammals_are_displayed()
    {
        // hit the mammals page
        $response = $this->get(url(self::ROUTE_MAMMALS));
        // assert that a 200 status is received.
        // assert that Name and Homeworld are displayed on the page.
        $response->assertStatus(200)
            ->assertSee('Name')
            ->assertSee('Homeworld');
    }
}
