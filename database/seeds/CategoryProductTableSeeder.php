<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        //Categories that don't have child categories.
        $categories = Category::where('id', '!=', 'parent_id')->get();
//        $parent_categories=Category::lists('parent_id');
//        $categories = Category::where('id', '!=', $parent_categories)->get();
//
//        dd($parent_categories);

        foreach ($products as $product) {
            DB::table('category_product')->insert([
                'category_id' => $categories->random()->id,
                'product_id' => $product->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
