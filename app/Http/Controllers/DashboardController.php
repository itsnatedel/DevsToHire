<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ModifyDashboardSettingsRequest;
    use App\Http\Requests\StoreJobRequest;
    use App\Models\Category;
    use App\Models\Dashboard;
    use App\Models\Location;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;
    use Symfony\Component\HttpFoundation\BinaryFileResponse;

    class DashboardController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index ()
        {
            return view('dashboard.index');
        }
        
        /**
         * Show the form for editing the specified resource.
         *
         * @return Application|Factory|View
         */
        public function edit ()
        {
            $user = User::where('id', Auth::id())->first();
            $user = Dashboard::getUserSettings($user);
            $categories = Category::all('id', 'name');
            $countries = Location::all('id', 'country_name');
            
            return view('dashboard.settings', compact([
                'user',
                'categories',
                'countries'
            ]));
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param ModifyDashboardSettingsRequest $request
         *
         * @return string
         */
        public function update (ModifyDashboardSettingsRequest $request)
        {
            $user = User::where('id', Auth::id())->first();
            Dashboard::checkAndUpdateSettings($request->validated(), $user);
            
            return redirect()->route('dashboard.settings');
        }
        
        /**
         * Shows the job creation form and populates the select fields
         *
         * @return Application|Factory|View
         */
        public function createJob ()
        {
            $types = DB::table('jobs')
                ->select('type')
                ->distinct()
                ->get();
            $categories = DB::table('categories')
                ->select('id', 'name')
                ->get();
            $countries = DB::table('locations')
                ->select('id', 'country_name')
                ->get();
            $remotes = DB::table('jobs')
                ->select('remote')
                ->distinct()
                ->get();
            
            return view('dashboard.post-job', compact([
                'types',
                'categories',
                'countries',
                'remotes'
            ]));
        }
        
        /**
         * @param StoreJobRequest $request
         *
         * @return RedirectResponse
         */
        public function storeJob (StoreJobRequest $request) : RedirectResponse
        {
            $jobId = Dashboard::createJobOffer($request);
            Dashboard::setJobSkills($request, $jobId);
            
            return redirect()->route('job.show', [$jobId, Str::slug($request->jobTitle)]);
        }
        
        /**
         * @return Application|Factory|View
         */
        public function createTask ()
        {
            $categories = Category::all('id', 'name');
            $locations = Location::all('id', 'country_name');
            
            return view('dashboard.post-task', compact([
                'categories',
                'locations'
            ]));
        }
        
        public function manageJobs ()
        {
            if (!in_array(Auth::user()->role_id, [2, 3])) {
                return redirect()
                    ->route('error-404')
                    ->with('message', 'You are not authorized to access this page !');
            }
            
            $freelancerId = null;
            $companyId = null;
            
            if (Auth::user()->role_id === 2) {
                $freelancerId = DB::table('freelancers')
                    ->select('user_id')
                    ->where('user_id', '=', Auth::id())
                    ->first()
                    ->user_id;
            }
            
            if (Auth::user()->role_id === 3) {
                $companyId = DB::table('companies')
                    ->select('id')->where('user_id', '=', Auth::id())
                    ->first()
                    ->id;
            }
            
            /**
             * If user is a freelancer, get job applications
             * Otherwise, get posted job offers
             */
            $jobs = Auth::user()->role_id === 2
                ? Dashboard::getAppliedJobs($freelancerId)
                : Dashboard::getActiveJobs($companyId);
            
            return view('dashboard.manage-jobs', compact([
                'jobs'
            ]));
        }
    
        /**
         * @return Application|Factory|View
         */
        public function manageTasks ()
        {
            if (Auth::user()->role_id === 2) {
                $tasks = Dashboard::getActiveTasks(true, Auth::user()->freelancer_id);
            } else {
                $tasks = Dashboard::getActiveTasks(false, Auth::user()->company_id);
            }
            
            return view('dashboard.manage-tasks', compact([
                'tasks'
            ]));
        }
        
        /**
         * Dashboard task manage
         */
        public function getActiveBids ()
        {
            if (Auth::user()->role_id !== 2) {
                return redirect()
                    ->route('error-404')
                    ->with('message', 'You are not authorized to access this page !');
            }
            
            $bids = null;
            
            // Get Tasks the freelancer bid on
            $bidderId = DB::table('freelancers')
                ->select('id')
                ->where('user_id', Auth::id())
                ->first()
                ->id;
            
            if (!is_null($bidderId)) {
                $bids = Dashboard::getActiveBids($bidderId);
            }
            
            return view('dashboard.my-bids', compact([
                'bids'
            ]));
        }
        
        /**
         * @method deleteBid
         * Handles the deletion of bids in dashboard
         *
         * @param int $bidId
         *
         * @return RedirectResponse
         */
        public function deleteBid (int $bidId) : RedirectResponse
        {
            // Check if bid exists, equals false if it doesn't
            $bidExists = !is_null(DB::table('bids')
                ->select('task_id')
                ->where('id', '=', $bidId)
                ->first()
                ->task_id);
            
            if ($bidExists) {
                if (DB::table('bids')
                    ->where('id', '=', $bidId)
                    ->delete()
                ) {
                    return redirect()->back()->with('success', 'Your bid was removed !');
                }
                
                return redirect()->back()->with('fail', 'There was a problem when removing your bid, please try again.');
            }
            
            return redirect()->route('error-404')->with('message', 'The bid you specified doesn\'t exist !');
        }
        
        /**
         * @method editBid
         * Edits a bid
         *
         * @throws ValidationException
         */
        public function editBid (Request $request) : RedirectResponse
        {
            $this->validate($request, [
                'bidId'  => 'required|string',
                'price'  => 'required|string',
                'time'   => 'required|string',
                'period' => 'required|string',
            ]);
            
            // Get corresponding bid
            $bid = DB::table('bids as b')
                ->join('tasks as ta', 'ta.id', '=', 'b.task_id')
                ->select('b.id', 'ta.budget_min', 'ta.budget_max')
                ->where('b.id', '=', $request->bidId)
                ->first();
            
            if (!is_null($bid)) {
                $price = (int)$request->price;
                
                if ($price >= $bid->budget_min && $price <= $bid->budget_max) {
                    if ((int)$request->time < 100) {
                        if (DB::table('bids')
                            ->where('id', '=', $bid->id)
                            ->update([
                                'minimal_rate'  => $price,
                                'delivery_time' => (int)$request->time,
                                'time_period'   => ucfirst($request->period),
                                'updated_at'    => Carbon::now()->toDayDateTimeString()
                            ])
                        ) {
                            return redirect()->back()->with('success', 'Your bid was updated !');
                        }
                        
                        return redirect()->back()->with('fail', 'There was a problem when modifying your bid, please try again.');
                    }
                    
                    return redirect()->back()->with('fail', 'Delivery time should not exceed more than 99.');
                }
                
                return redirect()->back()->with('fail', 'Price should not be lower or higher than the task\'s budget.');
            }
            
            return redirect()->back()->with('fail', 'No such bid was found in our servers.');
        }
        
        /**
         * @return Application|Factory|View|RedirectResponse
         */
        public function manageTaskBidders (int $taskId, string $slug)
        {
            
            $taskExists = Controller::resourceExists('task', $taskId,$slug);
    
            if (!$taskExists) {
                return redirect()->route('error-404')->with('message', 'No task matches the given query parameters.');
            }
            
            $task = DB::table('tasks')
                ->select('id', 'name', 'slug')
                ->where('id', '=', $taskId)
                ->first();
            
            // Sort if requested
            $bidders = isset(app('request')->sortBy)
                ? Dashboard::getTaskBidders($taskId, app('request')->sortBy)
                : Dashboard::getTaskBidders($taskId);
            
            $countBidders = DB::table('bids')
                ->select(DB::raw('COUNT(id) as count'))
                ->where('task_id', '=', $taskId)
                ->first()
                ->count;
            
            return view('dashboard.manage-bidders', compact([
                'task',
                'bidders',
                'countBidders'
            ]));
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @return Application|Factory|View
         */
        public function reviews ()
        {
            return view('dashboard.reviews');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @return Application|Factory|View
         */
        public function messages ()
        {
            return view('dashboard.messages');
            
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @return Application|Factory|View
         */
        public function bookmarks ()
        {
            return view('dashboard.bookmarks');
            
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param Request $request
         *
         * @return Application|Factory|View|RedirectResponse
         */
        public function candidates (Request $request)
        {
            if (Auth::user()->role_id === 3) {
                if (!isset($request->jobId)) {
                    // Get all candidates if no jobId
                    $jobs = Dashboard::getAllJobsCandidates(Auth::user()->company_id);
                }
                else {
                    // Get specific job's candidates
                    $jobs = Dashboard::getSingleJobCandidates(Auth::user()->company_id, $request->jobId);
                    
                    // Requested job not found
                    if (is_null($jobs->job_id) || !$jobs) {
                        return redirect()->route('error-404')->with('message', 'The requested job offer couldn\'t be found !');
                    }
                }
                
                // Company's active jobs
                return view('dashboard.manage-candidates', compact([
                    'jobs'
                ]));
            }
            
            return redirect()->route('error-404')->with('message', 'You are not authorized to access this page !');
        }
        
        /**
         * Downloads the CV from a candidate's offer
         *
         * @param $file
         * @param $userId
         *
         * @return RedirectResponse|BinaryFileResponse
         */
        public function downloadCV ($file, $userId)
        {
            if (!Auth::check() || Auth::user()->role_id !== 3) {
                return redirect()->route('error-404')->with('message', 'You are not authorized to access this page !');
            }
            
            $dir_url = DB::table('users as u')
                ->select('u.dir_url')
                ->where('u.id', '=', $userId)
                ->first()
                ->dir_url;
            
            return response()->download(public_path('images/user/' . $dir_url . '/files/' . $file));
        }
        
        /**
         * Deletes a candidate from a job offer
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function deleteCandidate (Request $request) : RedirectResponse
        {
            DB::table('candidates')
                ->where('user_id', '=', $request->candidateId)
                ->delete();
            
            return redirect()->back()->with('success', 'Candidate has been removed !');
        }
    }