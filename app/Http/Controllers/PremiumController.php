<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PremiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $premiumPlans = DB::table('premium')->get();
        
        return view('premium.index', compact('premiumPlans'));
    }
}