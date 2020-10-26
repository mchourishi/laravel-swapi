<?php

namespace App\Http\Controllers;

use App\Http\Services\SwapiLog;
use App\Http\Services\Swapi;

class MammalController extends Controller
{

    public function __construct()
    {
        $this->swapi = new Swapi();
    }

    /**
     * Get Mammal Species with homeworld.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMammals(){
        try {
            $mammals = $this->swapi->getMammals();
            $data = $mammals['data'];
            $mammals = $mammals['mammals'];
            SwapiLog::write('info', "Successfully retrieved mammals.");
            return view('mammal_homeworlds', compact('data', 'mammals'));
        }catch (\Exception $e){
            SwapiLog::write('error', "Error retrieving mammals:".$e->getMessage());
        }

    }
}
