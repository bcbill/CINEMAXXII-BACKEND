<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\support\Facades\DB;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('time');

            $table->uuid('theatre_id');
            $table->foreign('theatre_id')
                ->references('id')->on('theatres')
                ->onDelete('cascade');

            $table->timestamps();
        });
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        DB::statement('ALTER TABLE "times" ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
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
        Schema::dropIfExists('times');
    }*/
}
