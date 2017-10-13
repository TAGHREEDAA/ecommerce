<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09/10/17
 * Time: 07:02 م
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;



class ErrorHandlerController extends Controller

{
    public function errorCode404()
    {
        return view('errors.404');
    }
}