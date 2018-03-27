<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; //for DB::statement

class CreateTheatresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theatres', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('movie_name');
            $table->integer('section')->unique();
            $table->timestamps();
        });
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        DB::statement('ALTER TABLE theatres ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        DB::statement('DROP EXTENSION IF EXISTS "uuid-ossp";');
    }
    /*public function down()
    {
        Schema::dropIfExists('theatres');
    }*/
}
