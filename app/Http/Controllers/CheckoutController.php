<?php

namespace App\Http\Controllers;

use App\Models\Premium;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $planDetails = Premium::where('id', app('request')->plan_id)->first();
        $data = [
            'intent' => auth()->user()->createSetupIntent()
        ];

        return view('checkout.index', compact([
            'planDetails'
        ]))->with($data);
    }

    public function suceeded()
    {
        return view('checkout.ordersuccess');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'two-step' => 'accepted',
            'token' => 'required',
        ]);

        $plan = DB::table('premium as pr')
            ->select('pr.*')
            ->where('pr.monthly_identifier', '=', $request->plan)
            ->orWhere('pr.yearly_identifier', '=', $request->plan)
            ->first();

        if ($request->subType === 'monthly') {
            $request->user()->newSubscription('default', $plan->stripe_monthly_id)->create($request->token);
        }

        if ($request->subType === 'yearly') {
            $request->user()->newSubscription('default', $plan->stripe_yearly_id)->create($request->token);
        }

        return redirect()->route('order.success');
    }

}
