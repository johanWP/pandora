<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class MapsController extends Controller
{

    public function showMaps($location)
    {
        $directory = '/var/www/pandora/storage/planos/'.$location; 
        $files = File::Files($directory);
        
        return view('maps.dir', compact('location','files','directory'));

    }

    
   public function showLocations()
    {
        $directory = '/var/www/pandora/storage/planos/'; 
        $locations = File::directories($directory);
        
        return view('maps.locations', compact('locations'));

    }


    public function showFile($location,$filename)
    {
        $path = '/var/www/pandora/storage/planos/' . $location . '/' . $filename;
    
        //if(!File::exists($path)) abort(404);
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }
}