<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Main_Categorie;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    //

    public function index()
    {
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);
        return view('admin.Vendors.index',compact('vendors'));


    }
    public function create()
    { 
        $categories= Main_Categorie::where('translation_of',0)->active()->get(); // get the default language 
        return view('admin.Vendors.create' , compact('categories'));

    }

    public function store()
    {
        
    }
}
