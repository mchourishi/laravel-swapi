<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PeopleTest extends TestCase
{
    use RefreshDatabase;

    private const PEOPLE_IMPORT = 'people.import';
    private const PEOPLE_CREATE = 'people.create';
    private const PEOPLE_STORE = 'people.store';
    private const PEOPLE_BACKUP_URL = '/people/backup/testbackup.sql';

    /** @test */
    public function people_are_imported()
    {
        // hit the import people route
        $this->get(route(self::PEOPLE_IMPORT));

        $this->assertDatabasehas('swapi_characters', ['name' => 'Luke Skywalker']);
    }

    /** @test */
    public function people_backup_is_stored()
    {
        // hit the backup people route
        $response = $this->get(url(self::PEOPLE_BACKUP_URL));
        $this->assertEquals("Successfully ran backup_people command.", $response->getContent());
        Storage::assertExists('/backups/testbackup.sql');
    }

    /** @test */
    public function create_character_view_is_seen(){
        // hit the create character view.
        $response = $this->get(route(self::PEOPLE_CREATE));
        $response->assertStatus(200)
            ->assertSee('Create Character')
            ->assertSee('Name')
            ->assertSee('Height')
            ->assertSee('Mass')
            ->assertSee('Gender')
            ->assertSee('Birth Year')
            ->assertSee('Homeworld')
            ->assertSee('Species')
            ->assertSee('Hair Color');
    }

    /** @test */
    public function new_character_is_created(){
        // build post array
        $postArray = [
            'name' => 'TestName',
            'height' => '200',
            'mass' => '300',
            'gender' => 'male',
            'hair_color' => 'black',
            'birth_year' => '1999',
            'homeworld_name' => 'home',
            'species_name' => 'testtt',
        ];

        // when I post to to the store route
        $response = $this->post(route(self::PEOPLE_STORE), $postArray);

        // assert that a 302 Redirection status is received
        // assert that the redirect was to the people create view
        $response->assertStatus(302)
            ->assertRedirect(route(self::PEOPLE_CREATE))
            ->assertSessionHas(['message' => 'Successfully created character.']);

        // assert the database has the new defect values
        $this->assertDatabaseHas('swapi_characters', $postArray);
    }

    /** @test */
    public function new_character_without_name_and_height_gives_error(){
        // build post array
        $postArray = [
            'mass' => '300',
            'gender' => 'male',
            'hair_color' => 'black',
            'birth_year' => '1999',
            'homeworld_name' => 'home',
            'species_name' => 'testtt',
        ];

        // when I post to to the store route
        $response = $this->post(route(self::PEOPLE_STORE), $postArray);

        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('height');
    }
}
