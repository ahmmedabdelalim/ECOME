<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use Illuminate\Http\Request;
use App\Models\Language;


class LanguagesController extends Controller
{
    //

    public function getAllLanguages()
    {
        $languages = Language::selection()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index', compact('languages'));
        
    }

    public function create ()
    {
        return view('admin.languages.create');
    }

    public function store (LanguageRequest $request)
    {
        // first validation
        // seconde insert and  save in db
        try{
        Language::create($request->except('_token'));
        return redirect()->route('admin.languages')->with(['success'=>'تم اضاه العنصر بنجاح']);
        }
        catch(\Exception $ex)
        {
            return redirect()->route('admin.languages')->with(['errors'=>'errore']);
        }

    }

    public function edit($id)
    {
        $language = Language::select()->find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with(['error' => 'هذه اللغة غير موجوده']);
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function update($id, LanguageRequest $request)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages.edit', $id)->with(['error' => 'هذه اللغة غير موجوده']);
            }


            if (!$request->has('active'))
                $request->request->add(['active' => 0]);

            $language->update($request->except('_token'));

            return redirect()->route('admin.languages')->with(['success' => 'تم تحديث اللغة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
    }


    public function delete($id)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages', $id)->with(['error' => 'هذه اللغة غير موجوده']);
            }
            $language->delete();

            return redirect()->route('admin.languages')->with(['success' => 'تم حذف اللغة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
    }

}
