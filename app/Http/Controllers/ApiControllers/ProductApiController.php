<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(array(
            'status' => 'success',
            'products' => Product::all(),
            'status_code' => 200
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if ($validator->fails()) {
            return response()->json(array(
                'status' => 'success',
                'error'=>$validator->errors(),
                'message' => 'Error! Faild to create product.',
                'status_code' => 422
            ));

        }


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

        return response()->json(array(
            'status' => 'success',
            'message' => 'Product created successfully',
            'product' => $prod,
            'status_code' => 201
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(array(
            'status' => 'success',
            'products' => Product::find($id),
            'status_code' => 200
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        if ($validator->fails()) {
            return response()->json(array(
                'status' => 'success',
                'error'=>$validator->errors(),
                'message' => 'Error! Faild to update product.',
                'status_code' => 422
            ));

        }

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
        $prod->categories()->attach($request->category_id);

        return response()->json(array(
            'status' => 'success',
            'message' => 'Product Updated successfully',
            'product' => $prod,
            'status_code' => 201
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedProd = Product::find($id);

        if(isset($deletedProd))
        {
            // we have to soft delete the image of the product with moving it into deleted_images
            // while restore deleted product we restore the image
            // hard delete for the pivot table records

            if ($deletedProd->image != 'default_product.png')
                rename(public_path('images/products/') . $deletedProd->image, public_path('images/deleted_images/') . $deletedProd->image);

            $deletedProd->categories()->detach();

            $deletedProd->delete();

            return response()->json(array(
                'status' => 'success',
                'message' => 'Product Deleted successfully',
                'status_code' => 204
            ));
    }
    else
        return response()->json(array(
            'status' => 'error',
            'message' => 'Invalid Product ID!',
            'status_code' => 404
        ));
    }
}
