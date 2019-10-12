<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompaniesTable.
 */
class CreateCompaniesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table) {
			$table->increments('id');
			
			$table->string('full_name');
			$table->string('name');
			$table->uuid('uuid');
			$table->string('einssa', 20);

			$table->integer('business_type_id')->unsigned()->index();
            $table->foreign('business_type_id')->references('id')->on('business_types');
			
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
		Schema::drop('companies');
	}
}
