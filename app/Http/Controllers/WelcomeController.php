<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\Premium;
use App\Models\Welcome;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $jobs = DB::table('jobs')->count();
        $freelancers = DB::table('freelancers')->count();
        $tasks = DB::table('tasks')->count();
        $categories = DB::table('categories')->get();

        $featuredJobs = Welcome::getFeaturedJobs();
        $featuredFreelancers = Welcome::getFeaturedFreelancers();
        $premiumPlans = Premium::all();

        return view('welcome', [
            'jobs'                  => $jobs,
            'freelancers'           => $freelancers,
            'tasks'                 => $tasks,
            'categories'            => $categories,
            'featuredJobs'          => $featuredJobs,
            'featuredFreelancers'   => $featuredFreelancers,
            'premiumPlans'          => $premiumPlans
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
     * @param Request $request
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
     * @return Response
     */
    public function show($id)
    {
        //
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
     * @param Request $request
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
