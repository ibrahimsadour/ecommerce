<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;


    
    protected $table = 'languages';

    protected $fillable = [
        'id ', 'abbr','locale','name','direction','active','created_at','updated_at'
    ];


    // deze een globaal scope om een active Lang   te laat zien with Methode(where('active',1)) 
    public function scopeActive ($query){

        return $query -> where('active',1);

    }
    // deze een globaal scope om te Select een bepalde items van de date base) 
    public function scopeSelection ($query){

        return $query -> select('id','abbr','locale','name','direction','active');

    }

    // deze een globaal scope om een active Languages te laat zien with Methode(where('active',1)) 
    public function getActive(){
        return   $this -> active == 1 ? 'active'  : 'inactive';
      }
}
