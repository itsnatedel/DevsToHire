<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Category;
    use App\Models\Job;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Validation\ValidationException;

    class JobController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index ()
        {
            $jobs = Job::getAllJobsAndCompanyInfo();
            $countries = Job::getCountries();
            $categories = Category::all();
            
            return view('job.index', [
                'jobs'       => $jobs,
                'countries'  => $countries,
                'categories' => $categories
            ]);
        }
        
        /**
         * Handles the search criteria and fetches the corresponding jobs.
         *
         * @param Request $request
         *
         * @return Application|Factory|View
         */
        final public function search (Request $request) : View
        {
            // User selected a sort method
            if (isset($request->sortBy) && in_array($request->sortBy, ['newest', 'oldest', 'random'])) {
                $jobs = Job::getAllJobsAndCompanyInfo($request, true, false);
            }
            else if (isset($request->title)) {
                $jobs = Job::getAllJobsAndCompanyInfo($request, false, false);
            }
            else {
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
                'jobs'       => $jobs,
                'countries'  => $countries,
                'categories' => $categories
            ]);
        }
        
        /**
         * Shows Dashboard form to create a job
         *
         * @return Application|Factory|View
         */
        public function create ()
        {
            return view('dashboard.post-job');
        }
        
        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         *
         * @return void
         */
        public function store (Request $request) : void
        {
            //
        }
        
        /**
         * Displays a single job
         *
         * @param int    $id
         * @param string $slug
         *
         * @return Application|Factory|View|RedirectResponse
         */
        public function show (int $id, string $slug)
        {
            $jobExists = Controller::resourceExists('job', $id, $slug);
            
            if (!$jobExists) {
                return redirect()->route('error-404')->with('message', 'No job matches the given query parameters.');
            }
            
            $job = Job::getAllDataOfJob($id, $slug);
            $relatedJobs = Job::getRelatedJobs($job);
            $category = Job::getCategoryName($job->category_id);
            $alreadyApplied = Job::checkUserApplied($id, Auth::id());
            $companyRating = Job::getCompanyRating($id);
            
            return view('job.show', compact([
                'job',
                'relatedJobs',
                'category',
                'alreadyApplied',
                'companyRating'
            ]));
        }
        
        
        /**
         * @method cancelJobApplication
         * Cancels the job's application
         *
         * @param Request $request
         *
         * @return RedirectResponse
         * @throws ValidationException
         */
        public function cancelJobApplication (Request $request) : RedirectResponse
        {
            $this->validate($request, [
                'freelancerId' => 'required|integer',
                'jobId'        => 'required|integer'
            ]);
            
            if (Job::cancelApplication($request->jobId, $request->freelancerId)) {
                return back()->with('success', 'Your application was successfully canceled !');
            }
            
            return back()->with('fail', 'There was an unexpected error, please try again.');
        }
        
        /**
         * Retrieves all jobs from a specific category
         *
         * @param int $id category_id
         *
         * @return Application|Factory|View
         */
        public function category (int $id)
        {
            $jobs = Job::getAllJobsAndCompanyInfo($id);
            
            // To populate select inputs in sidebar
            $countries = Job::getCountries();
            $categories = Category::all();
            
            return view('job.index', [
                'jobs'       => $jobs,
                'countries'  => $countries,
                'categories' => $categories
            ]);
        }
        
        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         *
         * @return Response
         */
        public function edit ($id)
        {
            //
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
         */
        public function deleteJob (Request $request) : RedirectResponse
        {
            // Make sure no candidates applied for the job
            $hasCandidates = DB::table('candidates')
                ->select(DB::raw('COUNT(id) as count'))
                ->where('job_id', '=', $request->jobId)
                ->first()
                ->count;
            
            if (!$hasCandidates) {
                $isDeleted = DB::table('jobs')
                    ->where('id', '=', $request->jobId)
                    ->where('company_id', '=', $request->companyId)
                    ->delete();
                
                if ($isDeleted) {
                    return redirect()->back()->with('success', 'The offer has been removed !');
                }
    
                return redirect()->back()->with('success', 'There was a problem when deleting your offer, please try again...');
            }
            
            return redirect()->back()->with('fail', 'Cannot delete an offer that has candidates !');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         *
         * @return Response
         */
        public function destroy ($id)
        {
            //
        }
        
    }