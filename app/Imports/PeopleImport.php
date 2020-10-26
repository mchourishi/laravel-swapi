<?php

namespace App\Imports;

use App\Http\Services\SwapiLog;
use App\Http\Services\Swapi;
use App\People;

class PeopleImport
{
    /**
     * FilmController constructor.
     */
    public function __construct()
    {
        $this->swapi = new Swapi();
    }

    /**
     * Import People to people table.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public  function importPeople(){
        try{
            // Get all People
            $allPeople = $this->swapi->getPeople();
            if($allPeople->results){
                foreach ($allPeople->results as $people){
                    // Check if person already exists.
                    $personExists = People::whereName($people->name)->first();
                    if(!$personExists) {
                        $arrPeople = $this->formatPeopleRecord($people);
                        People::create($arrPeople);
                        SwapiLog::write('info', "Successfully imported : {$people->name}");
                    }else{
                        SwapiLog::write('info', "Not importing, person {$people->name} already exists");
                    }
                }
            }
            return "Import process finished..";
        }catch (\Exception $e){
            SwapiLog::write('error', "Error importing people:".$e->getMessage());
            return "Import Error..";
        }
    }


    /**
     * Get only required fields from people.
     * @param $people
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function formatPeopleRecord($people){
        $arrPeople = [];
        $arrPeople['name'] = $people->name;
        $arrPeople['height'] = $people->height;
        $arrPeople['mass'] = $people->mass;
        $arrPeople['hair_color'] = $people->hair_color;
        $arrPeople['birth_year'] = $people->birth_year;
        $arrPeople['gender'] = $people->gender;
        $homeworld_url = ($people->homeworld) ? $people->homeworld : "";
        $homeworld_name = '';
        $species_name = '';
        if(!empty($homeworld_url)){
            $homeworld = $this->swapi->sendRequest($homeworld_url);
            $homeworld_name = ($homeworld->name) ? ($homeworld->name) : "";
        }
        $arrPeople['homeworld_name'] = $homeworld_name;
        $speciesUrl = (count($people->species)) ? ($people->species[0]) : "";
        if(!empty($speciesUrl)){
            $species = $this->swapi->sendRequest($speciesUrl);
            $species_name = ($species->name) ? ($species->name) : "";
        }
        $arrPeople['species_name'] = $species_name;
        return $arrPeople;
    }
}
