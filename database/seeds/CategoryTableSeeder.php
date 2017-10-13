<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * We are going to insert 30 categories.
         */
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            DB::table('categories')->insert([
                'name' => implode($faker->words(),' '),
                'description' => implode($faker->words(),' '),
                'parent_id' => (($i % 2) === 0) ? $this->get_random_category_id() : null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }

    private function get_random_category_id()
    {
        $random_category = Category::inRandomOrder()->first();
        return !is_null($random_category) ? $random_category->id : null;
    }

}
