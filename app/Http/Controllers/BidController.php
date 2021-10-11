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
     * Handles bid's placement
     *
     * @param PlaceBidRequest $request
     * @param int             $taskId
     *
     * @return RedirectResponse
     */
    public function placeBid(PlaceBidRequest $request, int $taskId) : RedirectResponse
    {
        if (is_null($request->bidderRole) || $request->bidderRole === '3') {
            return redirect()->back()->withFail('You must be a freelancer to bid on a task !');
        }
        
        if (is_null($request->bidderId)) {
            return redirect()->back()->withFail('You must be signed in to bid on a task !');
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