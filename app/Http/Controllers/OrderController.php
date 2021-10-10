<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function success()
    {
        $invoiceId = app('request')->user()->invoices()->first()->id;

        return view('order.success', compact(['invoiceId']));
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function error()
    {
        return view('order.error');
    }
    
}