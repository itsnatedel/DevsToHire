<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTaskRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tasks = Task::getTasks();
        $fixedRates = Task::getFixedRatesLimits();
        $hourlyRates = Task::getHourlyRatesLimits();

        foreach ($tasks as $task) {
            $task->skills = Task::getSkills($task->id);
        }

        // Populate form inputs
        $categories = Category::all(['id', 'name']);
        $locations = Location::all(['id', 'country_name']);
        $skills = DB::table('skills')->get('skill');

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
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        $tasks = empty($request->sortBy)
            ? Task::getTasks($request)
            : Task::getTasks($request, true);
        
        return Controller::getTasksDetails($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveTaskRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SaveTaskRequest $request): RedirectResponse
    {
        $dir = User::where('freelancer_id', Auth::user()->freelancer_id)->get('dir_url')->first()->dir_url;

        $dueDate = Carbon::now();

        $request['taskDuration'] === 'days'
            ? $dueDate->addDays((int)$request['qtyInput'])
            : $dueDate->addMonths((int)$request['qtyInput']);

        $dueDate = $dueDate->toDateTimeString();

        $taskId = DB::table('tasks')
            ->insertGetId([
                'name'          => $request['taskTitle'],
                'description'   => $request['description'],
                'budget_min'    => (int)$request['budget_min'],
                'budget_max'    => (int)$request['budget_max'],
                'location_id'   => $request['location'],
                'type'          => ucfirst($request['radio']),
                'dir_url'       => $dir,
                'due_date'      => $dueDate,
                'created_at'    => Carbon::now()->toDateTimeString(),
                'category_id'   => $request['category']
            ]);

        if ($request->has('files')) {
            Task::uploadFile($taskId, Auth::user()->dir_url);
        }

        if (Auth::user()->role_id === 2) {
            DB::table('tasks')
                ->where('id', $taskId)
                ->update(['freelancer_id' => Auth::user()->freelancer_id]);
        }

        if (Auth::user()->role_id === 3) {
            DB::table('tasks')
                ->where('id', $taskId)
                ->update(['freelancer_id' => Auth::user()->company_id]);
        }

        DB::table('skills_tasks')
            ->insert([
                'task_id' => $taskId,
                'skills' => json_encode([$request['skills']])
            ]);

        return redirect()->route('dashboard.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $taskId
     *
     * @return Application|Factory|View
     */
    public function show(int $taskId)
    {
        $task = Task::getTaskInfo($taskId);

        if (!is_null($task->employer_id)) {
            $company_rating = Company::getCompanyRating($task->employer_id);
        } else {
            $company_rating = 0;
        }

        $location = DB::table('locations')
            ->select('country_code', 'country_name')
            ->where('id', '=', $task->location_id)->first();
        
        $bids = Task::getBids($taskId);
        $skills = Task::getSkills($taskId);

        return view('task.show', compact([
            'task',
            'company_rating',
            'location',
            'skills',
            'bids'
        ]));
    }
    
    /**
     * Downloads the project brief file uploaded by the task's owner
     *
     */
    public function downloadBrief($taskId, $fileUrl): BinaryFileResponse
    {
        $task = Task::where('id', $taskId)->first();
        
        return response()->download(public_path('images/user/' . $task->dir_url . '/files/' . $fileUrl));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
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
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Dashboard task manage
     */
    public function manage()
    {
        return view('dashboard.manage-tasks');
    }
}