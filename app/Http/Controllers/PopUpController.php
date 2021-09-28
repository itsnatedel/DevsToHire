<?php

namespace App\Http\Controllers;

use App\Models\PopUp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MakeOfferRequest;
use Illuminate\Validation\ValidationException;

class PopUpController extends Controller
{
	/**
	 * @method applyJob
	 * @param int                      $jobId
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 * @throws ValidationException
	 */
	public function applyJob(int $jobId, Request $request): RedirectResponse
	{
		$this->validate($request, [
			'name' => 'required|string',
			'email' => 'required|email'
		]);
		
		$employerId = PopUp::getEmployerId($jobId);
		
		if (PopUp::addCandidate($jobId, $employerId, $request->candidateId)) {
			return back()->with('success', 'The employer has been notified you\'re interested in this job !');
		} else {
			return back()->with('fail', 'An error occurred, please try again.');
		}
	}
	
	/**
	 * @method makeOffer
	 * @param \App\Http\Requests\MakeOfferRequest $request
	 * @param int                                 $freelancerId
	 * @param int                                 $userId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function makeOffer(MakeOfferRequest $request, int $freelancerId, int $userId): RedirectResponse
	{
		if (PopUp::storeOffer($request, $freelancerId, $userId)) {
			return back()->with('success', 'Your offer has been sent !');
		} else {
			return back()->with('notice', 'There was a problem during the process, please try again.');
		}
	}
}