<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->foreign()->references('id')->on('orders');
			$table->integer('product_id')->foreign()->references('id')->on('products');
			$table->decimal('qty', 10, 3);
			$table->integer('uom_id')->foreign()->references('id')->on('uoms');
			$table->decimal('price', 10, 2);
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
		Schema::drop('order_details');
	}

}
