<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesrequest;
use App\Models\Main_Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MainCategoriesController extends Controller
{
    public function getAllCategories()
    {
        $default_lang=get_default_lang();
        $categories = Main_Categorie::where('translation_lang',$default_lang)->selection()->paginate(PAGINATION_COUNT);
        return view('admin.Main_Categories.index', compact('categories'));
         
    }
##############################################
    public function create ()
    {
        return view('admin.Main_Categories.create');
    }

    ###########################

    public function store(MainCategoriesrequest $request)
    {
        //return $request;
        try {
        $main_categories = collect($request->categorie);// get the categorie in collection to make filter

        $filter = $main_categories->filter(function($value,$key) // filter the categorie from request using default lang
        {
            return $value['abbr'] == get_default_lang();//it return an value as object 
        });
        $default_categorie= array_values($filter->all())[0]; // store the value as object of filter in array and get the index [0]
        

        // save the photo 
        $file_path = "";
        if($request->has('photo'))
        {
            $file_path = uploadImage('main_categories',$request->photo);
        }
        
        DB::beginTransaction(); // begin of multi insert

        $default_categorie_id = Main_Categorie::insertGetId([ //insert the data in DB and get the ID

            'translation_lang'=> $default_categorie['abbr'], // get the abbr from array in the above
            'translation_of'=> '0',
            'name' =>  $default_categorie['name'],
            'slug' =>  $default_categorie['name'],
            'photo' =>  $file_path,

        ]);

        // get the not default lang using filter
            $other_categorie = $main_categories->filter(function($value,$key)
        {
            return $value['abbr'] != get_default_lang();
        }); 
        

        if(isset($other_categorie) && $other_categorie->count())
        {
            $categories_arr=[];
            foreach($other_categorie as $category)
            {
                Main_Categorie::insert(['translation_lang'=> $category['abbr'], // get the abbr from array in the above
                'translation_of'=> $default_categorie_id,
                'name' => $category['name'],
                'slug' => $category['name'],
                'photo' =>  $file_path,
                    
                    ]);
               /* 
                $categories_arr=[
            'translation_lang'=> $category['abbr'], // get the abbr from array in the above
            'translation_of'=> $default_categorie_id,
            'name' => $category['name'],
            'slug' => $category['name'],
            'photo' =>  $file_path,

                ];*/
                
            }
            

           // Main_Categorie::insert([$categories_arr]);
        }
        DB::commit();// commit if the multi insert  success

        return redirect()->route('admin.categories')->with(['success'=>'تم اضافه العنصر بنجاح']);
      }catch(\Exception $ex)
      {
        DB::rollback();
        return redirect()->route('admin.categories')->with(['error'=>'خطا في اضافه القسم']);
      }
      
    }
################################################

public function edit($id)

{        // get the cateogry and its translation
      $mainCategories=Main_Categorie::with('categories')->selection()->find($id);

    if(!$mainCategories)
    {
        return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
    }
    return view('admin.Main_Categories.edit',compact('mainCategories'));


}

public function update($id,MainCategoriesrequest $request)
{   
    $mainCategories=Main_Categorie::find($id);

    if(!$mainCategories)
    {
        return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
    }


      $Main_categroy= array_values($request->categorie)[0];// save the request in array

    if (!$request->has('categorie.0.active'))// check the acctive 
          {  $request->request->add(['active' => 0]);}
    else
        {$request->request->add(['active' => 1]);}


    Main_Categorie::where('id',$id)
    ->update([
        'name'=>$Main_categroy['name'],
        'active'=> $request->active,  // get the active using $request beacause the active may be not in array as 0
        
    ]);

    //////////// save image
        if($request->has('photo'))
        {
            $file_path = uploadImage('main_categories',$request->photo);
            Main_Categorie::where('id',$id)
            ->update([
                'photo'=> $file_path,
            ]);
    
        }
    return redirect()->route('admin.categories')->with(['success'=>'تم التعديل العنصر بنجاح']);


}



}
