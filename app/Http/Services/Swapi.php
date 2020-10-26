<?php
/**
 * Service for handling SWAPI API calls
 * User: Mukta
 * Date: 24/10/2020
 * Time: 4:40 PM
 */

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class Swapi
{

    /**
     * @var string $swapiUrl
     */
    protected $swapiBaseUrl = '';


    /**
     * Swapi constructor.
     */
    public function __construct()
    {
        $this->swapiBaseUrl = 'https://swapi.dev/api/';
    }

    /**
     * Build SWAPI URL from the parameters received.
     * @param string $resource
     * @param int|null $resourceId
     * @param string $search
     * @return string
     */
    public function buildUrl(string $resource, int $resourceId = null , string $search = ''){
        $swapiApiUrl = '';
        $swapiApiUrl.= $this->swapiBaseUrl.$resource."/";
        if(!empty($resourceId)){
            $swapiApiUrl.=$resourceId."/";
        }
        if(!empty($search)){
            $swapiApiUrl.="?search=".$search;
        }
        return $swapiApiUrl;
    }

    /**
     * Send Request to SWAPI URL
     * @param string $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(string $url){
        $client = new Client(['verify' => false]);
        $response = $client->request('GET', $url);
        return json_decode($response->getBody());
    }

    /**
     * Get Films : All films, Film By Resource Id, Films filtered by name.
     * @param string $name
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFilms(string $name = ''){
        $url = $this->buildUrl('films',null, $name);
        return $this->sendRequest($url);
    }

    /**
     * Get Film Characters
     * @param string $film
     * @return array $character
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFilmCharacters(string $film){
        $film = $this->getFilms($film);
        $data = [];
        $results = [];
        if($film->results){
            $characterUrls = ($film->results[0]->characters) ? $film->results[0]->characters : [];
            $data = $this->paginate($characterUrls);
            foreach($data as $characterUrl){
                $results[] = $this->sendRequest($characterUrl);
            }
        }
        return ["url" => $data, "results" =>$results];
    }

    /**
     * Get all Species
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSpecies(){
        $url = $this->buildUrl('species',null,'');
        return $this->sendRequest($url);
    }

    /**
     * Get Mammals from Species
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMammals(){
        $species = $this->getSpecies();
        $mammals = [];
        if($species->results){
            $collect = collect($species->results);
            $results = $collect->where('classification', 'mammal');
            $data = $this->paginate($results->toArray());
            foreach($data as $key => $result){
                $mammals[$key]['name'] = $result->name;
                $homeworld = ($result->homeworld) ? $this->sendRequest($result->homeworld) : "";
                $mammals[$key]['homeworld'] = ($homeworld)? $homeworld->name : "";
            }
        }
        return ["data" => $data, "mammals" => $mammals];
    }

    /**
     * Get All People.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPeople(){
        $url = $this->buildUrl('people',null,'');
        return $this->sendRequest($url);
    }

    /**
     * Return All Species Names.
     * @return array|Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function speciesNames(){
        $allSpecies = $this->getSpecies();
        $species = [];
        if($allSpecies->results){
            $species = collect($allSpecies->results)->pluck('name')->toArray();
        }
        return $species;
    }

    /**
     * Get Planet Names.
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPlanetNames(){
        $allPlanets = [];
        $url = $this->buildUrl('planets',null,'');
        $planets = $this->sendRequest($url);
        if($planets->results){
            $allPlanets = collect($planets->results)->pluck('name')->toArray();
        }
        return $allPlanets;
    }

    /**
     * Paginate : Display 2 items per page.
     * @param $items
     * @return LengthAwarePaginator
     */
    public function paginate($items){
        $page = Request::get('page', 1); // Get the ?page=1 from the url
        $perPage = 2; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($items, $offset, $perPage, true), // Only grab the items we need
            count($items), // Total items
            $perPage, // Items per page
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
