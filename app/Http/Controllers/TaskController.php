<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tasks              = Task::getTasks();
        $fixedRates         = Task::getFixedRatesLimits();
        $hourlyRates        = Task::getHourlyRatesLimits();
        $categories         = Category::all(['id', 'name']);
        $locations          = Location::all(['id', 'country_name']);
        $skills             = DB::table('skills')->get('skill');

        return view('task.index',
            compact([
                'tasks',
                'categories',
                'locations',
                'skills',
                'fixedRates',
                'hourlyRates'
            ]));
    }

    /**
     * Gather the tasks & search depending on the request's data
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request) {
        $tasks = empty($request->sortBy)
            ? Task::getTasks($request)
            : Task::getTasks($request, true);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('dashboard.post-task');
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
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        $task           = Task::getTaskInfo($id);
        $company_rating = Company::getCompanyRating($task->company_id);
        $location       = Location::find($task->location_id);
        $skills         = Task::getSkills($id);

        return view('task.show', compact([
            'task',
            'company_rating',
            'location',
            'skills'
        ]));
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

    /**
     * Dashboard task manage
     */
    public function manage() {
        return view('dashboard.manage-tasks');
    }
}
