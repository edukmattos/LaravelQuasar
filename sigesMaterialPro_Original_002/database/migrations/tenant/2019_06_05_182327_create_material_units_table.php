<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMaterialUnitsTable.
 */
class CreateMaterialUnitsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material_units', function(Blueprint $table) {
            $table->increments('id');

			$table->string('code', 15);
			$table->string('description', 40);

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
		Schema::drop('material_units');
	}
}
