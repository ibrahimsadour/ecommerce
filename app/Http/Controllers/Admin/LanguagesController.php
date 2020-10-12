<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Http\Requests\LanguageRequest;
use Illuminate\Support\Facades\Lang;

class LanguagesController extends Controller
{
    public function index(){
        
        // select() dit functie wordt in de Model gemaakt om te Select een bepalde items van de date base
        // PAGINATION_COUNT : een vast variabel bestaat in de route/admin.php , om alleen 10 items te laat zien om de pagina
        $languages = Language::select()->paginate(PAGINATION_COUNT);

        return view('admin.languages.index',compact('languages'));
    }

    public function create(){
        
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request)
    {
        // try en catch is gemaakt om het tonen van de error pagina  voor de admin te voorkomen
        // als een error bestaat dan geeft een bepalde messege 
        try {

            Language::create($request->except(['_token']));
            return redirect()->route('admin.languages')->with(['success' => 'The language has been saved successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'There is an error, please try again']);
        }
    }

    public function edit($id)
    {
        $language = Language::select()->find($id);
        if (!$language) {
            return redirect()->route('admin.languages')->with(['error' => 'This language does not exist']);
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function update($id, LanguageRequest $request)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages.edit', $id)->with(['error' => 'This language does not exist']);
            }


            if (!$request->has('active'))
                $request->request->add(['active' => 0]);

            $language->update($request->except('_token'));

            return redirect()->route('admin.languages')->with(['success' => 'The language has been successfully updated']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'There is an error, please try again']);
        }
    }

    public function destroy($id)
    {

        try {
            $language = Language::find($id);
            if (!$language) {
                return redirect()->route('admin.languages', $id)->with(['error' => 'This language does not exist']);
            }
            $language->delete();

            return redirect()->route('admin.languages')->with(['success' => 'Language successfully deleted']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'There is an error, please try again']);
        }
    }

    public function changeStatus($id)
    {
        try {
            $language = Language::find($id);
            if (!$language)
                return redirect()->route('admin.languages')->with(['error' => 'This language does not exist ']);

           $status =  $language -> active  == 0 ? 1 : 0;

           $language -> update(['active' =>$status ]);

            return redirect()->route('admin.languages')->with(['success' => 'The language status has been successfully updated']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'There is an error, please try again']);
        }
    }

}
