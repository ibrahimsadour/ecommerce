<?php
#################################################################################
// Deze bestaand is gemaakt door Ibrahim Sadour 06-10-2020
// hier wordt een bepalde methode gemaakt 
// deze methode kan ik in de heel website gebruiken.
##################################################################################

use Illuminate\Support\Facades\Config;


// deze om te Select all active languages
// Selection() deze is scope (gemaakt in de Languages models) 
// active() deze een globaal scope om een active Languages te laat zien with Methode(where('active',1)) 
function get_languages(){

    return \App\Models\Language::active() -> Selection() -> get();
}
// deze method pakket de huidig taal
function get_default_lang(){
  return   Config::get('app.locale');
}

// deze method gemaakt voor het insert van de images
function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}



function uploadVideo($folder, $video)
{
    $video->store('/', $folder);
    $filename = $video->hashName();
    $path = 'video/' . $folder . '/' . $filename;
    return $path;
}


define('PAGINATION_COUNT',10); // PAGINATION_COUNT : een vast variabel  om alleen 10 items te laat zien om de pagina
