<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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
	 * @return \Illuminate\Database\Query\Builder
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
}