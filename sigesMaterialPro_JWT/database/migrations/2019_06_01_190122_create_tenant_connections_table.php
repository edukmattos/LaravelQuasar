<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTenantConnectionsTable.
 */
class CreateTenantConnectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tenant_connections', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on('companies');

			$table->string('database');
			
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tenant_connections');
	}
}
