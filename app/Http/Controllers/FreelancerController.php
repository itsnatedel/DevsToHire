<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Location;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $freelancers        = Freelancer::getFreelancersInfos();
        $hourlyRateLimits   = Freelancer::getHourlyRateLimits();
        $categories         = Category::all('id', 'name');
        $countries          = Location::all('id', 'country_name');
        $sortOption         = $request->sortOption ?? null;
        $form               = null;

        return view('freelancer.index', compact([
            'freelancers',
            'hourlyRateLimits',
            'categories',
            'countries',
            'sortOption',
            'form'
        ]));
    }

    /**
     * Searches for a resource
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        if (!is_null($request->sortOption)) {
            $freelancers = Freelancer::getFreelancersInfos($request, true);
        } else {
            $freelancers = Freelancer::getFreelancersInfos($request);
        }

        $hourlyRateLimits   = Freelancer::getHourlyRateLimits();
        $categories         = Category::all('id', 'name');
        $countries          = Location::all('id', 'country_name');
        $sortOption         = $request->sortOption ?? null;

        // Populate inputs with selected
        $form = $request;

        return view('freelancer.index', compact([
            'freelancers',
            'hourlyRateLimits',
            'categories',
            'countries',
            'sortOption',
            'form'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function downloadCV($freelancerId, $CV_id)
    {
        $freelancer = Freelancer::where('id', $freelancerId)->first();
        
        $freelancer->dir_url = DB::table('users as u')
            ->select('u.dir_url')
            ->where('u.freelancer_id', '=', $freelancerId)
            ->first()
            ->dir_url;

        return response()->download(public_path('images/user/' . $freelancer->dir_url . '/files/' . $CV_id . '.pdf'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id Freelancer id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(int $id)
    {
        // Check if Freelancer exists w/ query params
        if (!Controller::resourceExists('freelancer', $id, app('request')->route()->parameter('fullname'))) {
            return redirect()->route('error-404')->with('message', 'No freelancer found with these parameters.');
        }
        
	    $freelancer         = DB::table('freelancers as fr')
            ->join('users as u', 'u.id', '=', 'fr.user_id')
            ->select('fr.*', 'u.pic_url as picUrl')
            ->where('fr.id', '=', $id)->first();
        
        $freelancer->skills = Freelancer::getFreelancerSkills($id);
        $freelancer->info   = Freelancer::getSingleFreelancerInfos($id);
        $freelancer->jobs   = Freelancer::getSingleFreelancerJobs($id);
        
        $freelancerId = DB::table('freelancers')
            ->select('user_id')
            ->where('id', '=', $id)->first()->user_id;
        
        $user = DB::table('users')->select('dir_url', 'can_be_rated')->where('id', $freelancerId)->first();

        if (!is_null($user)) {
            $freelancer->dir_url    = $user->dir_url;
            $freelancer->canBeRated = $user->can_be_rated;
        }

        return view('freelancer.show', compact([
            'freelancer'
        ]));
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
}