<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ModifyDashboardSettingsRequest;
    use App\Http\Requests\StoreJobRequest;
    use App\Models\Category;
    use App\Models\Dashboard;
    use App\Models\Location;
    use App\Models\User;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

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
            $user           = User::where('id', Auth::id())->first();
            $user           = Dashboard::getUserSettings($user);
            $categories     = Category::all('id', 'name');
            $countries      = Location::all('id', 'country_name');
            
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
    
        public function removeAttachments (Request $request)
        {
            dd($request, Auth::user());
        }
        
        /**
         * Shows the job creation form and populates the select fields
         *
         * @return Application|Factory|View
         */
        public function createJob ()
        {
            $types = DB::table('jobs')->select('type')->distinct()->get();
            $categories = DB::table('categories')->select('id', 'name')->get();
            $countries = DB::table('locations')->select('id', 'country_name')->get();
            $remotes = DB::table('jobs')->select('remote')->distinct()->get();
            
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
        
        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
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
         * @param int $id
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
         * @param int $id
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
         * @param int $id
         *
         * @return Application|Factory|View
         */
        public function candidates ()
        {
            return view('dashboard.manage-candidates');
        }
    }