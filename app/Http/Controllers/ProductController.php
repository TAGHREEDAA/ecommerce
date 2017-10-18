<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::paginate(10);
        flash('Welcome Aboard!');
        return view('Product.index')->with('Products',$products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
//        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('Product.form')
            ->with('Categories',$categories)
            ->with('mode','store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'price' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id'=>'required'

        ]);


        if ($validator->passes()) {

            // store
            $prod = new Product();
            $prod->name       = $request->name;
            $prod->price      = $request->price;
            $prod->description= strip_tags($request->description, '<br>');

            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $prod->image=$imageName;
                $uploadSuccess = $file->move(public_path('images/products'), $imageName);
            }
            $prod->save();

            // save the pivot table data
            // insert a record for each  category
            $prod->categories()->attach($request->category_id);
            return redirect()->route('product.index')->with('success','Product created successfully');
        }
        return redirect()->back()->with(['errors'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product= Product::find($id);

        if(isset($product))
            return view('Product.show',compact('product',$product));
        else {
            return redirect()->route('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Product = Product::find($id);
        if(isset($Product))
        {
            $categories = Category::all();
            // if we want to add products only to the last level of categories
            //        $categories = Category::whereNull('parent_id')->with('children')->get();
            $prodCategoriesIDs = [];
            foreach ($Product->categories as $cat) {
                $prodCategoriesIDs[] = $cat->id;
            }
    //        dd($prodCategoriesIDs);

            return view('Product.form')
                ->with('Categories', $categories)
                ->with('Product', $Product)
                ->with('prodCategoriesIDs', $prodCategoriesIDs)
                ->with('mode', 'update');
        }
        else {
            return redirect()->route('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prod = Product::findOrFail($id);

        $validator =Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name,'.$prod->id,
            'price' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id'=>'required'

        ]);

        if ($validator->passes()) {

            $prod->name       = $request->name;
            $prod->price      = $request->price;
            $prod->description= strip_tags($request->description, '<br>');


            if($request->hasFile('image'))
            {
                // 1- check if a new file was uploaded

                // delete old image
                unlink(public_path('images/products/').$prod->image);

                // 2- replace the current image with the new file
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $prod->image=$imageName;
                $uploadSuccess = $file->move(public_path('images/products'), $imageName);
            }
            // 3- if not change don't change the last one
            $prod->save();

            // save the pivot table data
            // insert a record for each  category
            $prod->categories()->detach();
            $prod->categories()->attach($request->category_id);
            return redirect()->route('product.index')->with('success','Product updated successfully');
        }
        return redirect()->back()->with(['errors'=>$validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedProd=Product::find($id);

        // we have to soft delete the image of the product with moving it into deleted_images
        // while restore deleted product we restore the image
        // hard delete for the pivot table records

        if($deletedProd->image != 'default_product.png')
            rename(public_path('images/products/').$deletedProd->image, public_path('images/deleted_images/').$deletedProd->image);

        $deletedProd->categories()->detach();

        $deletedProd->delete();

        return redirect()->route('product.index')

            ->with('success','Product has been deleted successfully');    }
}
