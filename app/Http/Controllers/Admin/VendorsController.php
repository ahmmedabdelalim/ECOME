<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Main_Categorie;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;
use App\Notifications\VendorCreated;
use Illuminate\Support\Facades\Notification;

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

    public function store(VendorRequest $request)
    {
        try{
            //// check if active 0 or 1 && put 0 if active not exist in request
            if(!$request->has('active'))
            {$request->request->add(['active'=>0]);}
            else{
                $request->request->add(['active'=>1]);
            }
            // save photo
            $file_path = "";
        if($request->has('logo'))
        {
            $file_path =  uploadImage('Vendors',$request->logo);
        }

            $vendor=Vendor::create([
                'name'=>$request->name,
                'mobile'=>$request->mobile,
                'email'=>$request->email,
                'active'=>$request->active,
                'address'=>$request->address,
                'logo'=>$file_path,
                'category_id'=>$request->category_id,
                'password'=>$request->password,
            ]);

            //$vendor->notify(new VendorCreated($vendor ));
             //Notification::send($vendor, new VendorCreated($vendor));

            return redirect()->route('admin.vendors')->with(['success'=>'تم اضافه العنصر بنجاح']);

        }
        catch(\Exception $ex)
        {
            //return $ex;
            return redirect()->route('admin.vendors')->with(['error'=>'خطا في اضافه القسم']);
        }
        
    }

    /////////// edit

    public function edit($id)
    {
           // get the Vendor 
           try {
            $vendors=Vendor::selection()->find($id);
            $categories= Main_Categorie::where('translation_of',0)->active()->get(); // get the default language

            if(!$vendors)
            {
                return redirect()->route('admin.vendors')->with(['error'=>'هذا القسم غير موجود']);
            }
            return view('admin.vendors.edit',compact('vendors','categories'));
          }
          catch(\Exception $ex)
          {
            return redirect()->route('admin.vendors')->with(['error'=>'خطا في اضافه القسم']);
          }

           }

           //////////////// update vendors

        public function update($id,VendorRequest $request)
        {
            try{
                $vendors=Vendor::find($id);

    if(!$vendors)
    {
        return redirect()->route('admin.vendors')->with(['error'=>'هذا القسم غير موجود']);
    }


     // $Main_categroy= array_values($request->categorie)[0];// save the request in array

    if (!$request->has('active'))// check the acctive 
          {  $request->request->add(['active' => 0]);}
    else
        {$request->request->add(['active' => 1]);}


    Vendor::where('id',$id)
    ->update([
        'name'=>$request->name,
        'active'=> $request->active,  // get the active using $request beacause the active may be not in array as 0
        
    ]);

    //////////// save image
        if($request->has('logo'))
        {
            $file_path = uploadImage('vendors',$request->logo);
            Vendor::where('id',$id)
            ->update([
                'logo'=> $file_path,
            ]);
    
        }
    return redirect()->route('admin.categories')->with(['success'=>'تم التعديل العنصر بنجاح']);

            }

            catch(\Exception $ex)
            {

            }
        }
     


}
