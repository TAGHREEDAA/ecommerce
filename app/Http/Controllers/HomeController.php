<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/10/17
 * Time: 07:13 م
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index')
            ->with('Categories',Category::all())
            ->with('Products',Product::all());
    }



}

