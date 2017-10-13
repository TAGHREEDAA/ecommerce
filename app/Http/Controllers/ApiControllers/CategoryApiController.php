<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
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
            'categories' => Category::all(),
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
            'name' => 'required|unique:categories|max:255',
            'parent_id'=>'required'

        ]);


        if ($validator->fails()) {
            return response()->json(array(
                'status' => 'success',
                'error'=>$validator->errors(),
                'message' => 'Error! Faild to create category.',
                'status_code' => 422
            ));

        }

        // store
        $cat = new Category();
        $cat->name       = $request->name;
        $cat->parent_id       = $request->parent_id;
        $cat->description= strip_tags($request->description, '<br>');
        $cat->save();


        return response()->json(array(
            'status' => 'success',
            'message' => 'Category created successfully',
            'category' => $cat,
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
            'categories' => Category::find($id),
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
        $cat = Category::findOrFail($id);

        $validator =Validator::make($request->all(), [

            'name' => 'required|max:255|unique:categories,name,'.$cat->id,
            'parent_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'status' => 'success',
                'error'=>$validator->errors(),
                'message' => 'Error! Faild to create category.',
                'status_code' => 422
            ));

        }

            // store
            $cat->name       = $request->name;
            $cat->parent_id       = $request->parent_id;
            $cat->description= strip_tags($request->description, '<br>');
            $cat->save();

            return response()->json(array(
                'status' => 'success',
                'message' => 'Category Updated successfully',
                'category' => $cat,
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
        //
    }
}
