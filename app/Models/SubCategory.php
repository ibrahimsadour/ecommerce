<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainCategory;

class SubCategory extends Model
{
    use HasFactory;


    
    protected $table = 'sub_categories';

    protected $fillable = [
        'id ','parent_id','category_id', 'translation_lang','translation_of','name','slug','photo','active','created_at','updated_at'
    ];

    
    /**
     * scopeActive
     *  deze een globaal scope om een active product of winkel te laat zien with Methode(where('active',1))
     * @param  mixed $query
     * @return void
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    
    /**
     * scopeSelection
     * select all items of the table sub_categories with this method
     * @param  mixed $query
     * @return void
     */
    public function scopeSelection($query)
    {

        return $query->select('id', 'category_id','translation_lang', 'name', 'slug', 'photo', 'active', 'translation_of');
    }

   
    /**
     * getPhotoAttribute
     * that is made with standard method (asset)
     * whene you get Photo from database (automacly added http://dominName/ecommerce/assets/)
     * @param  mixed $val
     * @return void
     */
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }

    public function getActive()
    {
        return $this->active == 1 ? 'active'  : 'inactive';

    }
    
    /**
     * scopeDefaultCategory
     * with this function get just the default Lang
     * @param  mixed $query
     * @return void
     */
    public function scopeDefaultSubCategory($query){
        return  $query -> where('translation_of',0);
    }
    /**
     * mainCategory
     * Get all main category of the sub category    
     * @return void
    */
    public  function mainCategory(){
        return $this -> belongsTo(MainCategory::class,'category_id','id');
    }
    
}
