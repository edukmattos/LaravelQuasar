<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientTypesTable.
 */
class CreateClientTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_types', function(Blueprint $table) {
            $table->increments('id');
			
			$table->string('code', 10);
			$table->string('description', 50);
			
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
		Schema::drop('client_types');
	}
}
