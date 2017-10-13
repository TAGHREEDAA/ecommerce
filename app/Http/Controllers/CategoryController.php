<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories=Category::paginate(10);

        return view('Category.index')->with('Categories',$Categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ParentCategories = Category::all();
        return view('Category.form')
            ->with('ParentCategories',$ParentCategories)
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
            'name' => 'required|unique:categories|max:255',
            'parent_id'=>'required'

        ]);

        if ($validator->passes()) {
            // store
            $cat = new Category();
            $cat->name       = $request->name;
            $cat->parent_id       = $request->parent_id;
            $cat->description= strip_tags($request->description, '<br>');
            $cat->save();

            return redirect()->route('category.index')->with('success','Category created successfully');
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
        $category= Category::find($id);

        if(isset($category))
            return view('Category.show')->with('category',$category);
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
        $Category=Category::find($id);
        if(isset($Category))
        {
            $ParentCategories = Category::all();
            return view('Category.form')
            ->with('ParentCategories',$ParentCategories)
            ->with('Category',$Category)
            ->with('mode','update');
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
        $cat = Category::findOrFail($id);

        $validator =Validator::make($request->all(), [

            'name' => 'required|max:255|unique:categories,name,'.$cat->id,
            'parent_id'=>'required'
        ]);

        if ($validator->passes()) {
            // store
            $cat->name       = $request->name;
            $cat->parent_id       = $request->parent_id;
            $cat->description= strip_tags($request->description, '<br>');
            $cat->save();

            return redirect()->route('category.index')->with('success','Category updated successfully');
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
        $deletedCategory=Category::find($id);
        $deletedCategory->products()->detach();
        $deletedCategory->delete();
        return redirect()->route('category.index')->with('success','Category has been deleted successfully');
    }

}
