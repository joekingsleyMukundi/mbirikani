<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $request, $slug=null)
    {

        //TODO Use logo or text, Change banner image and text
        $pages = Page::all();
        if($slug==null){
            $currentPage = Page::where('slug', "home")->first();
        }else{
            $currentPage = Page::where('slug', $slug)->first();
        }


        if(!$currentPage){
            abort(404);
        }


        return view('page', compact('pages', 'currentPage'));
    }

}
