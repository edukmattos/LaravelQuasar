<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientLocationsTable.
 */
class CreateClientLocationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_locations', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('client_id')->unsigned()->index();
			$table->foreign('client_id')->references('id')->on('clients');
			
			$table->integer('client_location_type_id')->unsigned()->index();
            $table->foreign('client_location_type_id')->references('id')->on('client_location_types');

			$table->boolean('main', 0);
			$table->string('code', 10);
			$table->string('description', 50);

			$table->string('place_id', 100)->nullable();
			$table->string('address', 100)->nullable();
			$table->integer('building')->nullable();
			$table->string('building_comments', 20)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('neighborhood', 30)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 2)->nullable();
			$table->string('phone', 11)->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('email', 50)->nullable();
			$table->string('comments', 200)->nullable();
			$table->string('lat', 15)->nullable();
			$table->string('lng', 15)->nullable();

			$table->timestamps();			
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('client_locations');
	}
}
