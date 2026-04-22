<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/news', function (Request $request) {

    try{
        $data = DB::table('offers')->get();
        return response()->json($data);

    }
    catch(\Exception $e){
    return response()->json(["error" => $e->getMessage()]);
    }

})->name('api.news');


Route::get("/marken", function (Request $request) {

    $disk = Storage::disk('public');
    $folder = 'marken';
    $exts = ['jpg','jpeg','png','webp','svg','avif'];

    //Wenn der Ordner nicht existiert, dann return Json
    if (!$disk->exists($folder)) return response()->json([]);

    $files = array_filter($disk->files($folder), function($p) use ($exts){
        return in_array(strtolower(pathinfo($p, PATHINFO_EXTENSION)), $exts, true);
    });

    sort($files, SORT_NATURAL | SORT_FLAG_CASE);

    // Nur URLs zurück
    $logos = array_map(fn($p) => [
        'name' => pathinfo($p, PATHINFO_FILENAME),
        'url'  => asset('storage/'.$p)
    ], $files);

    return response()->json($logos);

});
