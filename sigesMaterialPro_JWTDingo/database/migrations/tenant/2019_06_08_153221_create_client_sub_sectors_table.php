<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientSubSectorsTable.
 */
class CreateClientSubSectorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_sub_sectors', function(Blueprint $table) {
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
		Schema::drop('client_sub_sectors');
	}
}
