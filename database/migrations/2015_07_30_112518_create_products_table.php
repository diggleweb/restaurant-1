<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->foreign()->references('id')->on('stores');
			$table->integer('product_category_id')->foreign()->references('id')->on('product_categories');
			$table->string('name', 255);
			$table->text('description');
			$table->decimal('price', 10, 2);
			$table->integer('uom_id')->foreign()->references('id')->on('uoms');
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
		Schema::drop('products');
	}

}
