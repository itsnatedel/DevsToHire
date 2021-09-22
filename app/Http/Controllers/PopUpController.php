<?php

namespace App\Http\Controllers;

use App\Models\PopUp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PopUpController extends Controller
{
	/**
	 * @method applyJob
	 * @param                          $jobId
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function applyJob($jobId, Request $request): RedirectResponse
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
}