<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompanySectorsTable.
 */
class CreateCompanySectorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_sectors', function(Blueprint $table) {
            $table->increments('id');
			
			$table->nestedSet();

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
		Schema::drop('company_sectors');
	}
}
