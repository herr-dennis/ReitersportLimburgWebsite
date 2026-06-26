<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

// Startseite (greift globalen Fallback)
Route::get('/', fn() => view('mainPage'))->name('home');

// --- DE-Routen: Slugs auflösen & Laufzeit-Locale setzen ---
App::setLocale('de'); // damit __() hier DE-Slugs liefert
Route::middleware('locale.de')->group(function () {
    Route::get(__('messages.routes.impressum'), fn() => view('impressumView'))->name('de.impressum');
    Route::get(__('messages.routes.dataprotection'), fn() => view('datenschutzView'))->name('de.datenschutz');
    Route::get(__('messages.routes.animalfeed'), fn() => view('tierfutterView'))->name('de.tierfutter');
    Route::get(__('messages.routes.horses'), fn() => view('pferdeView'))->name('de.pferdebedarf');
    Route::get(__('messages.routes.rider'), fn() => view('reiterView'))->name('de.reiter');
    Route::get(__('messages.routes.shop'), fn() => view('shopView'))->name('de.geschäft');
    Route::get(__('messages.routes.contact'), fn() => view('contactView'))->name('de.contact');
    Route::get(__('messages.routes.garden'), fn() => view('gardenView'))->name('de.garten');
});

// --- NL-Routen: Slugs auflösen & Laufzeit-Locale setzen ---
App::setLocale('nl'); // damit __() hier NL-Slugs liefert
Route::middleware('locale.nl')->group(function () {
    Route::get(__('messages.routes.impressum'), fn() => view('impressumView'))->name('nl.impressum');     // Colofon
    Route::get(__('messages.routes.dataprotection'), fn() => view('datenschutzView'))->name('nl.datenschutz'); // Privacybeleid
    Route::get(__('messages.routes.animalfeed'), fn() => view('tierfutterView'))->name('nl.tierfutter');
    Route::get(__('messages.routes.horses'), fn() => view('pferdeView'))->name('nl.pferdebedarf');
    Route::get(__('messages.routes.rider'), fn() => view('reiterView'))->name('nl.reiter');
    Route::get(__('messages.routes.shop'), fn() => view('shopView'))->name('nl.geschäft');
    Route::get(__('messages.routes.contact'), fn() => view('contactView'))->name('nl.contact');
    Route::get(__('messages.routes.garden'), fn() => view('gardenView'))->name('nl.tuin');
});

// Optional: App-Locale zurücksetzen (nicht zwingend)
App::setLocale(config('app.locale'));

// routes/web.php

Route::get("/Admin", function () { return view('adminView');})->name('admin');


Route::get('/ruitersport limburg/{any?}', function ($any = null) {
    return redirect('/' . $any, 301);
})->where('any', '.*');

Route::get('/{page}.html', function ($page) {
    return redirect('/' . $page, 301);
});
Route::get('/{page}.html', function ($page) {
    return redirect('/' . $page, 301);
});

Route::get('/locale/{lang}', function ($lang) {
    if (! in_array($lang, ['de', 'nl'])) {
        $lang = 'nl'; // Fallback
    }

    Session::put('locale', $lang);
    App::setLocale($lang);

    return Redirect::to("/");
})->name('locale.switch');


Route::get('/{any}', function ($any) {
    if ($any === 'index.html') {
        return redirect('/', 301);
    }

    if (Str::startsWith($any, 'ruitersport limburg/')) {
        return redirect('/' . Str::after($any, 'ruitersport limburg/'), 301);
    }

    abort(404);
})->where('any', '.*');
