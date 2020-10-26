<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    /**
     * @var string
     */
    protected $table = 'swapi_characters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'height', 'mass', 'hair_color', 'gender', 'birth_year', 'homeworld_name', 'species_name'
    ];
}
