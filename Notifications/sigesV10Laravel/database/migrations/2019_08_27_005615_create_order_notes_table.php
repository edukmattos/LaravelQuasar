<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrderNotesTable.
 */
class CreateOrderNotesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_notes', function(Blueprint $table) {
            $table->increments('id');
			
			$table->integer('order_id')->unsigned()->index();
			$table->foreign('order_id')->references('id')->on('orders');
			
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users');
			
			$table->string('note');
			
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
		Schema::drop('order_notes');
	}
}
