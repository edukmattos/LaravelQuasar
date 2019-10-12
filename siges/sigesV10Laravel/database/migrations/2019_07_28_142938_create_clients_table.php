<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientsTable.
 */
class CreateClientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('client_type_id')->unsigned()->index();
			$table->foreign('client_type_id')->references('id')->on('client_types');
			
			$table->integer('client_status_id')->unsigned()->index();
            $table->foreign('client_status_id')->references('id')->on('client_statuses');

			$table->string('full_name');
			$table->string('name');
			$table->string('einssa', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('mobile', 20)->nullable();
			$table->string('phone', 20)->nullable();

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
		Schema::drop('clients');
	}
}
