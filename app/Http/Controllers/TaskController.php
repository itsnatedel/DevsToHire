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
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;

    class TaskController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index ()
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
        public function search (Request $request)
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
        public function store (SaveTaskRequest $request) : RedirectResponse
        {
            $dir = User::where('freelancer_id', Auth::user()->freelancer_id)->get('dir_url')->first()->dir_url;
            
            $dueDate = Carbon::now();
            
            $request['taskDuration'] === 'days'
                ? $dueDate->addDays((int)$request['qtyInput'])
                : $dueDate->addMonths((int)$request['qtyInput']);
            
            $dueDate = $dueDate->toDateTimeString();
            
            $taskId = DB::table('tasks')
                ->insertGetId([
                    'name'        => $request['taskTitle'],
                    'slug'        => Str::slug($request['taskTitle']),
                    'description' => $request['description'],
                    'budget_min'  => (int)$request['budget_min'],
                    'budget_max'  => (int)$request['budget_max'],
                    'location_id' => $request['location'],
                    'type'        => ucfirst($request['radio']),
                    'dir_url'     => $dir,
                    'due_date'    => $dueDate,
                    'created_at'  => Carbon::now()->toDateTimeString(),
                    'category_id' => $request['category']
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
                    ->update(['employer_id' => Auth::user()->company_id]);
            }
            
            DB::table('skills_tasks')
                ->insert([
                    'task_id' => $taskId,
                    'skills'  => json_encode([$request['skills']])
                ]);
            
            return redirect()->route('dashboard.task.manage');
        }
        
        /**
         * Display the specified resource.
         *
         * @param int $taskId
         *
         * @return Application|Factory|View|RedirectResponse
         */
        public function show (int $taskId)
        {
            $taskExists = Controller::resourceExists('task', $taskId, app('request')->route()->parameter('slug'));
            
            if (!$taskExists) {
                return redirect()->route('error-404')->with('message', 'No task matches the given query parameters.');
            }
            
            $task = Task::getTaskInfo($taskId);
            
            if (!is_null($task->employer_id)) {
                $company_rating = Company::getCompanyRating($task->employer_id);
            }
            else {
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
        public function downloadBrief ($taskId, $fileUrl)
        {
            $task = Task::where('id', $taskId)->first();
            
            if (!is_null($task)) {
                return file_exists(public_path('images/user/' . $task->dir_url . '/files/' . $fileUrl))
                    ? response()->download(public_path('images/user/' . $task->dir_url . '/files/' . $fileUrl))
                    : redirect()->route('error-404')->with('message', 'The file you\'re trying to download doesn\'t exist.');
            }
            
            redirect()->route('error-404')->with('message', 'The project you\'re trying to access doesn\'t exist.');
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         * @param int     $id
         *
         * @return Response
         */
        public function update (Request $request, $id)
        {
            //
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param         $taskId
         * @param Request $request
         *
         * @return RedirectResponse
         * @throws ValidationException
         */
        public function deleteTask ($taskId, Request $request) : RedirectResponse
        {
            $this->validate($request, [
                'freelancer_id' => 'sometimes|string',
                'employer_id'   => 'sometimes|string',
            ]);
            
            // Check if task exists
            $taskExists = !is_null(DB::table('tasks as ta')
                ->select('freelancer_id', 'employer_id')
                ->where('ta.id', '=', $taskId)
                ->first());
            
            if ($taskExists) {
                $taskDeleted = DB::table('tasks')
                    ->where('id', '=', $taskId)
                    ->delete();
                
                if ($taskDeleted) {
                    return redirect()->back()->with('success', 'Your task has been deleted !');
                }
                
                return redirect()->back()->with('fail', 'There was a problem when deleting your task, try again...');
            }
            
            return redirect()->route('error-404')->with('message', 'No matching task could be found.');
        }
    }