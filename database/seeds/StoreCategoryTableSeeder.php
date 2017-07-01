<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreCategory;

class StoreCategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('store_categories')->delete();

        StoreCategory::create([
        	['name' => 'test1','display_mode' => 'PRODUCT'],
        	['name' => 'tes2','display_mode' => 'PRODUCT'],
        	['name' => 'test3','display_mode' => 'PRODUCT'],
        	['name' => 'test4','display_mode' => 'STORE'],
        	['name' => 'test5','display_mode' => 'PRODUCT']
        	]);
        $this->command->info('store_categories table seeded!');
    }

}