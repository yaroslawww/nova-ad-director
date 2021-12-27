<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('nova-ad-director.tables.ad_configurations'),
            function (Blueprint $table) {
                $table->id();
                $table->string('key', 255)->index();
                $table->string('location', 150)->index();
                $table->string('status', 50)->default('disabled')->index();
                $table->json('configuration')->nullable();
                $table->timestamps();

                $table->unique(['key', 'location']);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('nova-ad-director.tables.ad_configurations'));
    }
}
