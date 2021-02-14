<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesrequest;
use App\Models\Main_Categorie;
use Illuminate\Http\Request;

class MainCategoriesController extends Controller
{
    public function getAllCategories()
    {
        $default_lang=get_default_lang();
        $categories = Main_Categorie::where('translation_lang',$default_lang)->selection()->paginate(PAGINATION_COUNT);
        return view('admin.Main_Categories.index', compact('categories'));
         
    }

    public function create ()
    {
        return view('admin.Main_Categories.create');
    }

    public function store(MainCategoriesrequest $request)
    {
        return $request;

    }
}
