<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $successRates       = Freelancer::getSuccessRateLimits();
        $categories         = Category::all('id', 'name');
        $countries          = Location::all('id', 'country_name');
        $sortOption         = $request->sortOption ?? null;
        $form               = null;

        return view('freelancer.index', compact([
            'freelancers',
            'hourlyRateLimits',
            'successRates',
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
        $successRates       = Freelancer::getSuccessRateLimits();
        $categories         = Category::all('id', 'name');
        $countries          = Location::all('id', 'country_name');
        $sortOption         = $request->sortOption ?? null;

        // Populate inputs with selected
        $form = $request;

        return view('freelancer.index', compact([
            'freelancers',
            'hourlyRateLimits',
            'successRates',
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
    public function downloadCV($freelancerId, $CV_id): BinaryFileResponse
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
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
	    $freelancer         = DB::table('freelancers')->where('id', $id)->first();
        $freelancer->skills = Freelancer::getFreelancerSkills($id);
        $freelancer->info   = Freelancer::getSingleFreelancerInfos($id);
        $freelancer->jobs   = Freelancer::getSingleFreelancerJobs($id);
		
        $user = DB::table('users')->select('dir_url', 'can_be_rated')->where('id', $id)->first();
		
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