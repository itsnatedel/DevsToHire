<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\MakeOfferRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PopUp extends Model
{
    use HasFactory;
	
	/**
	 * @method getEmployer
	 * Retrieves the employer of the job listing
	 *
	 * @param $jobId
	 *
	 * @return mixed
	 */
	public static function getEmployerId($jobId)
	{
		return DB::table('jobs as jo')
			->join('companies as co', 'co.id', '=', 'jo.company_id')
			->select('co.user_id as id')
			->where('jo.id', '=', $jobId)
			->first()
			->id;
	}
	
	/**
	 * @method addCandidate
	 * @param $jobId
	 * @param $employerId
	 * @param $freelancerId
	 *
	 * @return bool
	 */
	public static function addCandidate($jobId, $employerId, $freelancerId): bool
	{
		return DB::table('candidates')
			->insert([
				'user_id'       => $freelancerId,
				'job_id'        => $jobId,
				'employer_id'   => $employerId
			]);
	}
	
	/**
	 * @method storeOffer
	 * @param \App\Http\Requests\MakeOfferRequest $request
	 * @param int                                 $freelancerId
	 * @param int                                 $userId
	 *
	 * @return bool
	 */
	public static function storeOffer(MakeOfferRequest $request, int $freelancerId, int $userId): bool
	{
		$fileName = self::getFileUrl($request);
		self::storeOfferFile($request, $fileName, Auth::user()->dir_url);
		
		return DB::table('offers')
			->insert([
				'message'       => $request->message,
				'file_url'      => $fileName,
				'offeror_name'  => $request->name,
				'offeror_email' => $request->email,
				'freelancer_id' => $freelancerId,
				'user_id'       => $userId
			]);
	}
	
	/**
	 * @method getFileUrl
	 * Generates an UUID for the filename
	 *
	 * @param \App\Http\Requests\MakeOfferRequest $request
	 *
	 * @return string
	 */
	private static function getFileUrl(MakeOfferRequest $request): string
	{
		return Uuid::uuid4() . '.' . $request->file('offerFile')->extension();
	}
	
	/**
	 * @param \App\Http\Requests\MakeOfferRequest $request
	 * @param string                              $fileName
	 * @param string                              $userDir
	 *
	 * @return bool
	 */
	private static function storeOfferFile(MakeOfferRequest $request, string $fileName, string $userDir): bool
	{
		 $request->file('offerFile')
			->move(public_path('images/user/' . $userDir . '/files'), $fileName);
		 
		 return true;
	}
}