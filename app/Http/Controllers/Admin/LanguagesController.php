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
            return redirect()->route('admin.languages')->with(['success' => 'تم حفظ اللغة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
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

    public function destroy($id)
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
