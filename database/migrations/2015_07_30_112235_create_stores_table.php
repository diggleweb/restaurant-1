<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_category_id')->foreign()->references('id')->on('store_categories');
			$table->string('name', 255);
			$table->text('description');
			$table->time('start_time');
			$table->time('end_time');
			$table->integer('delivery_time');
			$table->decimal('tax', 10, 7);
			$table->decimal('vat', 10, 7);
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
		Schema::drop('stores');
	}

}
