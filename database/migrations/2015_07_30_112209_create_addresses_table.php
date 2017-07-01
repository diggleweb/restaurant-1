<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reference_id');
			$table->enum('reference_type', ['CUSTOMER',  'STORE',  'ORDER']);
			$table->decimal('lat', 11,8);
			$table->decimal('long', 11,8);
			$table->string('address1', 255)->nullable();
			$table->string('address2', 255)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('pincode', 10)->nullable();
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
		Schema::drop('addresses');
	}

}
