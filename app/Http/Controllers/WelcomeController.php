<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\Welcome;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
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
                // To populate select inputs in sidebar
                $countries  = Job::getCountries();
                $categories = Category::all();

                return view('job.index', [
                    'jobs' => $jobs,
                    'countries' => $countries,
                    'categories' => $categories
                ]);
            }

            if ($taskOrJob === 'task') {
                $tasks              = Welcome::searchJobsOrTasks($request, $taskOrJob);

                foreach ($tasks as $task) {
                    $task->skills = Task::getSkills($task->id);
                }

                $fixedRates         = Task::getFixedRatesLimits();
                $hourlyRates        = Task::getHourlyRatesLimits();
                $categories         = Category::all(['id', 'name']);
                $locations          = Location::all(['id', 'country_name']);
                $skills             = DB::table('skills')->get('skill');

                return view('task.index', compact([
                    'tasks',
                    'categories',
                    'locations',
                    'skills',
                    'fixedRates',
                    'hourlyRates'
                ]));
            }
        } else {
            return back()->withFail('No match found, try again !');
        }
    }
}