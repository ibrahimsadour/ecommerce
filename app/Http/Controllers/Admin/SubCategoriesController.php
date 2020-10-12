<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use DB;
use App\Models\SubCategory;
use Illuminate\Support\Str;
class SubCategoriesController extends Controller
{

    public function index()
    {
        // selection() deze methode is gemaakt in de Models 
        $default_lang = get_default_lang();
        $sub_categories = SubCategory::where('translation_lang', $default_lang)
            ->selection()
            ->orderBy('id','DESC') -> paginate(PAGINATION_COUNT);

        // $categories = SubCategory::orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('admin.subcategories.index', compact('sub_categories'));
    }

    public function create()
    {
        $default_lang = get_default_lang();
        // $categories = MainCategory::where('translation_of', 0)->active()->get();
         $categories = MainCategory::where('translation_lang', $default_lang)->active()->orderBy('id','DESC') -> get();
        return view('admin.subcategories.create',compact('categories'));
    }


    public function store(SubCategoryRequest $request)
    {

        try {
            // return $request;


            //  veranderen van object(array) naar collection with deze regel
            $sub_categories = collect($request->category);


            /*
            1 - ik haal alle talen
            2- taal splitsen op de basis van de (defult language)
            3 - slaa eerste de (defult languag op)
            4 - slaa de rest van de talen op
            translation_lang (ar -en-nl-uk) enz..
            translation_of : de vertalen van de eeste toegoegd items
            
            Bijvoorbeeld : in de form voeg ik de foto daarna de name in bepalde taal 
            en de tweede naam is de vertaling van de eerste naam.
            */
            $filter = $sub_categories->filter(function ($value, $key) {
                return $value['abbr'] == get_default_lang();
            });

            // veranderen van object naar array
            $default_category = array_values($filter->all()) [0];


            $filePath = "";
            if ($request->has('photo')) {

                $filePath = uploadImage('subcategories', $request->photo);
            }

            DB::beginTransaction(); 
            
            //Deze gemaakt omdat meer dan insert proces heb in hier
            ### try {
            ### DB::beginTransaction();
            ### code hier
            ### DB::commit();
            ### } catch (\Exception $ex) {
            ### DB::rollback();
            ### }

            // return $default_category;

            $default_category_id = SubCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'category_id'=>$request->category_id,
                'name' => $default_category['name'],
                'slug' => $default_category['slug'],
                'photo' => $filePath
            ]);
                
            $categories = $sub_categories->filter(function ($value, $key) {
                return $value['abbr'] != get_default_lang();
            });


            if (isset($categories) && $categories->count()) {

                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'category_id'=>$request->category_id,
                        'name' => $category['name'],
                        'slug' => $category['slug'],
                        'photo' => $filePath
                    ];
                }

                SubCategory::insert($categories_arr);
            }

            DB::commit();

            return redirect()->route('admin.subcategories')->with(['success' => 'تم الحفظ بنجاح']);

        } catch (\Exception $ex) {
            return $ex;
            DB::rollback();
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {

        //get specific categories and its translations
        $sub_categories = SubCategory::Selection()->find($id);

        if (!$sub_categories)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

        $default_lang = get_default_lang();
        $main_categories = MainCategory::where('translation_lang', $default_lang)->active()->orderBy('id','DESC') -> get();


        return view('admin.subcategories.edit', compact('main_categories','sub_categories'));

    }


    public function update($Sub_id, SubCategoryRequest $request)
    {
        try {
            //validation => SubCategoryRequest

            //update DB ===>

            //find sub_categories
            $sub_categories = SubCategory::find($Sub_id);

            if (!$sub_categories)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);


            // update date

            $category = array_values($request->category) [0];

            if (!$request->has('category.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

                SubCategory::where('id', $Sub_id)
                ->update([
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'active' => $request->active,
                ]);

                // save image
                if ($request->has('photo')) {
                    $filePath = uploadImage('subcategories', $request->photo);
                    SubCategory::where('id', $Sub_id)
                        ->update([
                            'photo' => $filePath,
                        ]);
                }

            return redirect()->route('admin.subcategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $sub_categories = SubCategory::find($id);

            if (!$sub_categories)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

            $sub_categories->delete();


            ## Delet image
            ##Srt is cutting helper method
            $image = Str::after($sub_categories->photo, 'assets/');
            $image = public_path('assets/' . $image);
            unlink($image); //delete from folder

            #Delet all translation of the categories
            $sub_categories -> categories() -> delete();
        
            #delet section
            $sub_categories->delete();

            return redirect()->route('admin.subcategories')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function changeStatus($id)
    {
        try {
            $sub_categories = SubCategory::find($id);
            if (!$sub_categories)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

           $status =  $sub_categories -> active  == 0 ? 1 : 0;

           $sub_categories -> update(['active' =>$status ]);

            return redirect()->route('admin.subcategories')->with(['success' => ' تم تغيير الحالة بنجاح ']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


}
