<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\Welcome;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
        $countJobs              = DB::table('jobs')->count('id');
        $countFreelancers       = DB::table('freelancers')->count('id');
        $countTasks             = DB::table('tasks')->count('id');;
        $tasks                  = Welcome::getRecentTasks();
        $categories             = Welcome::jobsPerCategory(DB::table('categories')->get());
        $featuredJobs           = Welcome::getFeaturedJobs();
        $featuredFreelancers    = Welcome::getFeaturedFreelancers();
        $premiumPlans           = DB::table('premium')->get();

        return view('welcome', compact([
            'countJobs',
            'countFreelancers',
            'countTasks',
            'tasks',
            'categories',
            'featuredJobs',
            'featuredFreelancers',
            'premiumPlans'
        ]));
    }
    
    /**
     * @param Request $request
     *
     * @return Application|Factory|View|void
     */
    public function search(Request $request)
    {
        if (is_null($request->type)) {
            return back()->withFail('Please select a type of job or task !');
        }

        $taskOrJob = Welcome::isTaskOrJob($request);

        if (!is_bool($taskOrJob)) {
            if ($taskOrJob === 'job') {
                $jobs       = Welcome::searchJobsOrTasks($request, $taskOrJob);
                
                // Populate select inputs in sidebar
                $countries  = Job::getCountries();
                $categories = Category::all();

                return view('job.index', [
                    'jobs'          => $jobs,
                    'countries'     => $countries,
                    'categories'    => $categories
                ]);
            }

            if ($taskOrJob === 'task') {
                $tasks = Welcome::searchJobsOrTasks($request, $taskOrJob);

                return Controller::getTasksDetails($tasks);
            }
        } else {
            return back()->withFail('No match found, try again !');
        }
    }
}