<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateCompanyRequest;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
    public function search($letter) {
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
     * @param int $id company's id
     * @return Application|Factory|View
     */
    public function show(int $id, Request $request)
    {
        $company = Company::getCompanyInfo($id);
        $openedPositions = Company::getOpenPositions($id);
        $tasks = Company::getOpenTasks($id);

        $ratings = $request->isMethod('post')
            ? Company::getRatings($id, $request->sortBy)
            : Company::getRatings($id);

        return view('company.show', [
            'company'           => $company,
            'openedPositions'   => $openedPositions,
            'tasks'             => $tasks,
            'ratings'           => $ratings
        ]);
    }
    
    /**
     * @param RateCompanyRequest $request
     * @param int                $companyId
     *
     * @return RedirectResponse
     */
    public function rate (RateCompanyRequest $request, int $companyId) : RedirectResponse
    {
        $isOldEmployee = Company::isOldEmployee($request->freelancerId, $companyId);
        $hasAlreadyRated = Company::hasRatedCompany($request->freelancerId, $companyId);
        
        if (!$isOldEmployee) {
            return redirect()
                ->back()
                ->with('fail', 'You must have been hired by this company to rate it !');
        }
        
        if ($hasAlreadyRated) {
            return redirect()
                ->back()
                ->with('fail', 'You cannot rate a company more than once !');
        }
        
        $rating = [
            'freelancer_id'     => $request->freelancerId,
            'company_id'        => $companyId,
            'note'              => $request->rating,
            'reviewTitle'       => $request->reviewTitle,
            'freelancer_name'   => $request->name,
            'comment'           => $request->comment,
        ];
        
        DB::table('ratings_companies')
            ->insert($rating);
        
        return redirect()
            ->back()
            ->with('success', 'You\'ve successfully rated this company !');
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