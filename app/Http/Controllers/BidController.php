<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceBidRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
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
     * Dashboard Manage Bidders
     *
     * @param  int  $id
     *
     * @return Application|Factory|View
     */
    public function manage($id)
    {
        return view('dashboard.manage-bidders');
    }

    /**
     * Dashboard Manage My Bids
     *
     * @param  int  $id
     *
     * @return Application|Factory|View
     */
    public function activeBids($id)
    {
        return view('dashboard.my-bids');
    }
    
    /**
     * Handles bid's placement
     *
     * @param PlaceBidRequest $request
     * @param int             $taskId
     *
     * @return RedirectResponse
     */
    public function placeBid(PlaceBidRequest $request, int $taskId) : RedirectResponse
    {
        if (is_null($request->bidderId)) {
            return redirect()->back()->withFail('You must be signed in to bid on a task !');
        }
        
        if (is_null($request->bidderRole) || $request->bidderRole === 3) {
            return redirect()->back()->withFail('You must be a freelancer to bid on a task !');
        }
        
        $bid = [
            'minimal_rate'  => $request->rate,
            'delivery_time' => $request->timespan,
            'time_period'   => $request->duration,
            'created_at'    => Carbon::now()->toDateTimeString(),
            'task_id'       => $taskId,
            'bidder_id'     => $request->bidderId,
        ];
        
        DB::table('bids')->insert($bid);
        
        return redirect()->back()->with('success', 'Your bid has been placed !');
    }
}