<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Dashboard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\StoreJobRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\ModifyDashboardSettingsRequest;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit()
    {
        $user = User::where('id', Auth::id())->first();
        $user->settings = Dashboard::getUserSettings($user);
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
    public function update(ModifyDashboardSettingsRequest $request)
    {
        $user = User::where('id', Auth::id())->first();
        Dashboard::checkAndUpdateSettings($request->validated(), $user);

        return redirect()->route('dashboard.settings');
    }
	
	/**
	 * Shows the job creation form and populates the select fields
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function createJob()
    {
		$types      = DB::table('jobs')->select('type')->distinct()->get();
		$categories = DB::table('categories')->select('id', 'name')->get();
		$countries  = DB::table('locations')->select('id', 'country_name')->get();
		$remotes     = DB::table('jobs')->select('remote')->distinct()->get();
		
        return view('dashboard.post-job', compact([
			'types',
	        'categories',
	        'countries',
	        'remotes'
        ]));
    }
	
	/**
	 * @param \App\Http\Requests\StoreJobRequest $request
	 */
	public function storeJob(StoreJobRequest $request)
	{
		$jobId = Dashboard::createJobOffer($request);
		Dashboard::setJobSkills($request, $jobId);
		
		return redirect()->route('job.show', [$jobId, Str::slug($request->jobTitle)]);
	}
	
	/**
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function createTask()
    {
        $categories = Category::all('id', 'name');
        $locations  = Location::all('id', 'country_name');

        return view('dashboard.post-task', compact([
            'categories',
            'locations'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function reviews()
    {
        return view('dashboard.reviews');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function messages()
    {
        return view('dashboard.messages');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function bookmarks()
    {
        return view('dashboard.bookmarks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function candidates()
    {
        return view('dashboard.manage-candidates');
    }
}