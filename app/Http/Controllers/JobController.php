<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $jobs = Job::getAllJobsAndCompanyInfo();
        $countries = Job::getCountries();
        $categories = Category::all();

        return view('job.index', [
            'jobs' => $jobs,
            'countries' => $countries,
            'categories' => $categories
        ]);
    }

    /**
     * Handles the search criterias and fetches the corresponding jobs.
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request) {
        // User selected a sort method
        if (isset($request->sortBy) && in_array($request->sortBy, ['newest', 'oldest', 'random'])) {
            $jobs = Job::getAllJobsAndCompanyInfo($request, true, false);
        } elseif (isset($request->title)) {
            $jobs = Job::getAllJobsAndCompanyInfo($request, false, false);
        } else {
            $jobs = Job::getAllJobsAndCompanyInfo();
        }

        // User searched with sidebar's inputs
        if (isset($request->search) && $request->search === 'refined') {
            $jobs = Job::getAllJobsAndCompanyInfo($request, false, true);
        }

        // To populate select inputs in sidebar
        $countries = Job::getCountries();
        $categories = Category::all();

        return view('job.index', [
            'jobs' => $jobs,
            'countries' => $countries,
            'categories' => $categories
        ]);
    }

    /**
     * Shows Dashboard form to create a job
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('dashboard.post-job');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Displays a single job
     *
     * @param int $id
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(int $id, string $slug)
    {
        $job = Job::getAllDataOfJob($id, $slug);
        $relatedJobs = Job::getRelatedJobs($job);
        $category = Job::getCategoryName($job->category_id);

        return view('job.show')->with(compact('job', 'relatedJobs', 'category'));
    }

    /**
     * Retrieves all jobs from a specific category
     *
     * @param int $id category_id
     * @return Application|Factory|View
     */
    public function category(int $id)
    {
        $jobs = Job::getAllJobsAndCompanyInfo($id);

        // To populate select inputs in sidebar
        $countries = Job::getCountries();
        $categories = Category::all();

        return view('job.index', [
            'jobs' => $jobs,
            'countries' => $countries,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /* Manage Job -> Dashboard */
    public function manage()
    {
        return view('dashboard.manage-jobs');
    }
}
