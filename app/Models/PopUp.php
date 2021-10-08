<?php

namespace App\Models;

use App\Http\Requests\MakeOfferRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
        $companyId = DB::table('jobs as jo')
            ->join('companies as co', 'co.id', '=', 'jo.company_id')
            ->select('co.id')
            ->where('jo.id', '=', $jobId)
            ->first()
            ->id;
        
        if (is_null($companyId)) {
            return DB::table('jobs as jo')
                ->join('companies as co', 'co.id', '=', 'jo.company_id')
                ->select('co.user_id as id')
                ->where('jo.id', '=', $jobId)
                ->first()
                ->id;
        }
        
        return $companyId;
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
	 * @param MakeOfferRequest $request
	 * @param int              $freelancerId
	 * @param int              $userId
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
	 * @param MakeOfferRequest $request
	 *
	 * @return string
	 */
	private static function getFileUrl(MakeOfferRequest $request): string
	{
		return Uuid::uuid4() . '.' . $request->file('offerFile')->extension();
	}
	
	/**
	 * @param MakeOfferRequest $request
	 * @param string           $fileName
	 * @param string           $userDir
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