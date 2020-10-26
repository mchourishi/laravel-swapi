<?php

namespace App\Http\Controllers;

use App\Http\Services\Swapi;
use App\Http\Services\SwapiLog;
use App\Imports\PeopleImport;
use App\People;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;


class PeopleController extends Controller
{

    private $validationRules;

    protected const ROUTE_CREATE = 'people.create';

    public function __construct()
    {
        $this->validationRules = [
            'name' => 'required',
            'height' => 'required|integer',
            'mass' => 'required|integer',
            'hair_color' => 'required|string',
            'birth_year' => 'required|string',
            'gender' => 'required|string',
            'homeworld_name' => 'required|string',
            'species_name' => 'string',
        ];
        $this->swapi = new Swapi();
    }

    /**
     * Import People
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function importPeople()
    {
        $import = new PeopleImport();
        try {
            $output = $import->importPeople();
            SwapiLog::write('info', "People Import finished with result = {$output}.");
            return $output;
        } catch (\Exception $e) {
            SwapiLog::write('error', "Error importing:" . $e->getMessage());
        }
    }

    /**
     * Update Characters from records in updated_character_data table.
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePeople()
    {
        $updatedPeople = DB::table('updated_character_data')->get();
        $messages = [];
        $validSpecies = $this->swapi->speciesNames();
        $validHomeworlds = $this->swapi->getPlanetNames();
        foreach ($updatedPeople as $people) {
            $people = json_decode(json_encode($people), true);
            unset($people['id']);

            $validator = Validator::make($people, $this->validationRules);
            $msg = '';
            if ($validator->fails()) {
                $msg = "Cant import {$people['name']},  error validating data : ".$validator->errors();
                SwapiLog::write('error', $msg);
            } else {
                //Validate the species is a valid swapi species.
                $species_name = (in_array($people['species_name'], $validSpecies)) ? $people['species_name'] : "";
                if(empty($species_name)){
                    unset($people['species_name']);
                }
                // Validate the homeworld is a valid homeworld.
                $homeworld_name = (in_array($people['homeworld_name'], $validHomeworlds)) ? $people['homeworld_name'] : "";
                if(empty($homeworld_name)){
                    unset($people['homeworld_name']);
                }
                // Update Data
                $result = People::whereName($people['name'])->update($people);
                if (isset($result)) {
                    $msg = "Successfully updated character {$people['name']}";
                    SwapiLog::write('info', $msg);
                }
            }
            $messages[] = $msg;
        }
        return implode("<br>", $messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create()
    {
        $species = $this->swapi->speciesNames();
        $homeworlds = $this->swapi->getPlanetNames();
        return view('create_character', compact('species', 'homeworlds'));
    }

    /**
     * Store People Resource.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate Form Params.
        $request->validate($this->validationRules);
        try {
            $people = People::create($request->all());
            $message = "Successfully created character.";
            SwapiLog::write('info', "{$message} : Character Id = {$people->id}");
            return redirect()->route(self::ROUTE_CREATE)->with('message', $message);
        } catch (\Exception $e) {
            $message = "Failed creating character";
            SwapiLog::write('error', "{$message} : {$e->getMessage()}");
            return redirect()->route(self::ROUTE_CREATE)->with('error', "{$message}, please try again.");
        }
    }

    /**
     * Run Command to Backup Characters Table.
     * @param string
     * @return int
     */
    public function backupPeople(string $file = ''){
        $file = (!empty($file)) ? $file : 'backup_people.sql';
        $return_code = Artisan::call("backup_people $file");
        if($return_code!=0){
            $msg = "Error Running Artisan backup_people command";
            SwapiLog::write('error', $msg);
        }else{
            $msg = "Successfully ran backup_people command.";
            SwapiLog::write('info', $msg);
        }
        return $msg;
    }
}
