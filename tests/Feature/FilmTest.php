<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmTest extends TestCase
{
    private const ROUTE_FILM = '/film/characters/jedi';

    /** @test */
    public function film_characters_are_displayed()
    {
        // hit the film characters page
        $response = $this->get(url(self::ROUTE_FILM));
        // assert that a 200 status is received.
        // assert that Name and Gender are displayed on the page.
        $response->assertStatus(200)
            ->assertSee('Name')
            ->assertSee('Gender');
    }
}
