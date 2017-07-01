<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;
use App\Models\Customer;

use App\Models\Address;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

// 		$this->call('StoreCategoryTableSeeder');

		$store_category_data= [
			['name' => 'store_category1','display_mode' => 'PRODUCT'],
			['name' => 'store_category2','display_mode' => 'STORE'],
			['name' => 'store_category3','display_mode' => 'PRODUCT'],
			['name' => 'store_category4','display_mode' => 'STORE'],
			['name' => 'store_category5','display_mode' => 'PRODUCT']
		];
		// $this->seed_table('store_categories', $store_category_data);

		$store_data= [
			[
				'store_category_id'=>1, 
				'name' => 'store1',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
						'lat'=>65.02,
						'long'=>85.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			],
			[
				'store_category_id'=>1, 
				'name' => 'store2',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
				'lat'=>1.02,
				'long'=>65.26,
				"address1" => "as akisdn g sdgsgs sdf",
				"address2" => "garias ldgd",
				"city" => "kolkata",
				"state" => "west bengal",
				"country" => "india",
				"pincode" => "700012"
					]
				]
			],
			[
				'store_category_id'=>1, 
				'name' => 'store3',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
						'lat'=>0.02,
						'long'=>65.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			],
			[
				'store_category_id'=>1, 
				'name' => 'store4',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
						'lat'=>105.02,
						'long'=>35.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			],
			[
				'store_category_id'=>1, 
				'name' => 'store5',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
						'lat'=>1.02,
						'long'=>57.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			],
			[
				'store_category_id'=>1, 
				'name' => 'store6',
				'description'=>'tea nasodngsd jsd gsd gsfg sfguoshf fg fog fgns ', 
				'start_time' => '10:25', 
				'end_time' => '05:26', 
				'delivery_time' => 50, 
				'tax' => 4.25, 
				'vat' => 3.25,
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			],
		];
		// $this->seed_stores_table($store_data);

		$customer_data= [
			[
				'name' => 'customer1','phone_no' => '9587145231',
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				],
			],[
				'name' => 'customer2','phone_no' => '9587145232',
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				],
			],[
				'name' => 'customer3','phone_no' => '9587145233',
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				],
			],[
				'name' => 'customer4','phone_no' => '9587145234',
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				],
			],[
				'name' => 'customer5','phone_no' => '9587145235',
				'address' => [
					[
						'lat'=>15.02,
						'long'=>59.26,
						"address1" => "as akisdn g sdgsgs sdf",
						"address2" => "garias ldgd",
						"city" => "kolkata",
						"state" => "west bengal",
						"country" => "india",
						"pincode" => "700012"
					]
				]
			]
		];
		$this->seed_customers_table($customer_data);
	}

	private function seed_table($table, $data){
		try{
			DB::table($table)->truncate();
			foreach ($data as $key => $value) {
				DB::table($table)->insert($value);
			}
			$this->command->info("$table table seeded successfully!");
		}
		catch(Exception $e){
			$this->command->error("$table table can not seeded,$e");
			throw new Exception("Error to seed table:".$table, 1);
		}
	}

	private function seed_stores_table($store_data){
		foreach ($store_data as $key => $value) {
			$addresses = $value['address'];
			unset($value['address']);
			$store = Store::Create($value);
			
			foreach ($addresses as $key => $address) {
				$address['reference_id']=$store->id;
				$address['reference_type']='STORE';
				Address::Create($address);
			}
		}
		$this->command->info("stores table seeded successfully!");
	}

	private function seed_customers_table($customer_data){
		foreach ($customer_data as $key => $value) {
			$addresses = $value['address'];
			unset($value['address']);
			$store = Customer::Create($value);
			
			foreach ($addresses as $key => $address) {
				$address['reference_id']=$store->id;
				$address['reference_type']='STORE';
				Address::Create($address);
			}
		}
		$this->command->info("customers table seeded successfully!");
	}
}
