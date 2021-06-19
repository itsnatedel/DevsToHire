<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $companies = Company::getFirstSetOfCompanies();

        return view('company.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Searches for companies by letter
     * @return Application|Factory|View
     */
    public function search(Request $request, $letter) {
        $companies = Company::searchCompaniesByLetter($letter);

        return view('company.index', [
            'companies' => $companies,
            'letter'    => $letter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id, $slug)
    {
        $company = Company::find($id);
        $openedPositions = Company::getOpenPositionsOfCompany($id);

        return view('company.show', [
            'company'           => $company,
            'openedPositions'   => $openedPositions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
