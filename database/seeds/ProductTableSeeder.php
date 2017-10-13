<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * We are going to insert 50 products.
         *  'name', 'image', 'description','price',
         */
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            DB::table('products')->insert([
                'name' => implode($faker->words(),' '),
                'image' => 'default_image.jpg',
                'description' => $faker->paragraph(),
                'price' => $this->mt_rand_float(0, 100),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }

    private function mt_rand_float($min, $max, $countZero = '0')
    {
        $countZero = +('1' . $countZero);
        $min = floor($min * $countZero);
        $max = floor($max * $countZero);
        $rand = mt_rand($min, $max) / $countZero;
        return $rand;
    }
}
