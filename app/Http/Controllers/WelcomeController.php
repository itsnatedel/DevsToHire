<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Job;
use App\Models\Premium;
use App\Models\Task;
use App\Models\Welcome;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // TODO: Refacto below fcts to take less time on loading homepage
        $jobs = count(Job::all());
        $freelancers = count(Freelancer::all());
        $tasks = count(Task::all());
        $categories = Category::all();

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
}
