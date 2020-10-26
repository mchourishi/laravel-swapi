<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapiCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapi_characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->integer('height');
            $table->integer('mass');
            $table->string('hair_color',20);
            $table->string('birth_year',10);
            $table->string('gender',10);
            $table->string('homeworld_name',80);
            $table->string('species_name',80)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapi_characters');
    }
}
