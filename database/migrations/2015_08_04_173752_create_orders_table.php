<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_ref_id', 100)->unique();
			$table->integer('customer_id')->foreign()->references('id')->on('customers');
			$table->decimal('tax', 10, 7);
			$table->decimal('vat', 10, 7);
			$table->decimal('total_price', 10, 2);
			$table->string('remarks', 255);
			$table->timestamp('deliver_at');
			$table->enum('order_status', ['PENDING',  'DELIVERED',  'PROCESSING',  'CANCELED']);
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
		Schema::drop('orders');
	}

}
