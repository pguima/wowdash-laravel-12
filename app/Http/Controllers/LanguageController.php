<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (array_key_exists($locale, config('app.available_locales', ['en' => 'English', 'pt_BR' => 'Portuguese (Brazil)', 'es' => 'Spanish']))) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        return redirect()->back();
    }
}
