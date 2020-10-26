<?php

namespace App\Http\Controllers;

use App\Http\Services\SwapiLog;
use App\Http\Services\Swapi;

class FilmController extends Controller
{

    /**
     * FilmController constructor.
     */
    public function __construct()
    {
        $this->swapi = new Swapi();
    }

    /**
     * Get Film Characters for a film.
     * @param string $film
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFilmCharacters(string $film){
        try {
            $characterDetails = $this->swapi->getFilmCharacters($film);
            $characters = $characterDetails["url"];
            $results = $characterDetails["results"];
            SwapiLog::write('info', "Successfully retrieved characters of film {$film}");
            return view('jedi_characters', compact('characters', 'results'));
        }catch (\Exception $e) {
            SwapiLog::write('error', "Error retrieving characters of film : ".$e->getMessage());
        }
    }

}
