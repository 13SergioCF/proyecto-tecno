<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoadingController extends Controller
{
    /**
     * Muestra la vista de loading.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('nutritionlDetail.loading'); // Asegúrate de que loading.blade.php esté en resources/views
    }
}
