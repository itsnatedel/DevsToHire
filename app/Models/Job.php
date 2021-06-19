<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class Job
 * @package App\Models
 */
class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'created_at',
        'modified_at',
        'title',
        'salary_low',
        'salary_high',
        'type',
        'description',
    ];

    /**
     * Relation Job -> Company
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation Job -> Category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param int $id
     * @param string $slug
     * @return Model|Builder|object|null
     */
    public static function getAllDataOfJob(int $id, string $slug)
    {
        $job = DB::table('jobs as jo')
            ->join('companies as co', 'co.id', '=', 'jo.company_id')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->select('jo.*',
                DB::raw('DATEDIFF(jo.created_at, NOW()) as date_posted'),
                'co.location_id',
                'co.name',
                'co.slug as company_slug',
                'co.description',
                'co.verified',
                'co.pic_url',
                'lo.country_name',
                'lo.country_code')
            ->where('jo.slug', 'like', '%' . $slug . '%')
            ->where('jo.id', '=', $id)
            ->first();

        self::removeDashesFromDates($job);
        self::getSalaryInThousands($job);

        return $job;
    }

    /**
     * getAllShowsAndCompanyInfo method.
     * Retrieves all shows & the employer's info
     */
    public static function getAllJobsAndCompanyInfo($request = null, bool $sort = false, bool $refined = false): LengthAwarePaginator
    {
        $query = DB::table('jobs as jo')
            ->join('companies as co', 'co.id', '=', 'jo.company_id')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->select('jo.*',
                DB::raw('DATEDIFF(jo.created_at, NOW()) as date_posted'),
                'co.location_id',
                'co.name',
                'co.slug as company_slug',
                'co.description',
                'co.verified',
                'co.pic_url',
                'lo.country_name');

        if (is_int($request)) {
            $query = self::getJobsByCategoryId($query, $request);
        }

        // User requests a sort method
        if (isset($request->sortBy) && $sort) {
            $query = self::sortQuery($query, $request->sortBy);
        }

        // User searches for a job title
        if (isset($request->title) && !is_null($request->title)) {
            $query = self::getJobsWithTitle($query, $request);
        }

        // If user searches for different criterias
        if ($refined) {
            $query = self::refinedSearch($query, $request);
        }

        $jobs = $query->paginate(4);

        self::removeDashesFromDates($jobs);
        self::getSalaryInThousands($jobs);

        return $jobs;
    }

    /**
     * getJobsByCategoryId method.
     * Searches jobs from a specific category
     * @param $query
     * @param int $request Category's id
     * @return mixed
     */
    public static function getJobsByCategoryId($query, int $request)
    {
        // Make sure the category exists
        $category = Category::where('id', '=', $request)->first();

        if (!is_null($category)) {
            return $query->where('jo.category_id', '=', $request);
        }

        // If category doesn't exist
        return $query;
    }

    /**
     * sortQuery method.
     * Sorts the list of jobs depending on user's request
     * @param $query
     * @param $sortByMethod
     * @return mixed
     */
    public static function sortQuery($query, $sortByMethod)
    {
        if (!is_null($sortByMethod)) {
            if ($sortByMethod === 'random') {
                $query->inRandomOrder();
            }

            if ($sortByMethod === 'newest') {
                $query->orderBy('jo.created_at', 'desc');
            } else {
                $query->orderBy('jo.created_at');
            }
        }

        return $query;
    }

    /**
     * getCountries method.
     * Retrieves all countries and their alpha2 codes.
     * @return Collection
     */
    public static function getCountries(): Collection
    {
        return DB::table('locations')->select('id', 'country_name as name')->get();
    }

    /**
     * Fetches the category for a job listing.
     * Needed to output the job's category name in job@show
     * @param $category_id
     * @return mixed
     */
    public static function getCategoryName($category_id) {
        return Category::where('id', '=', $category_id)->first();
    }

    /**
     * getJobsWithTitle method.
     * Searches any match with a given title
     * @param $query
     * @param Request $request
     * @return mixed
     */
    public static function getJobsWithTitle($query, Request $request)
    {
        $query->where('title', 'like', '%' . $request->title . '%');

        return $query;
    }

    /**
     * refinedSearch method.
     * Searches for any record match with user's search criterias
     * @param $query
     * @param Request $request
     * @return mixed
     */
    protected static function refinedSearch($query, Request $request)
    {

        if (isset($request->country)) {
            $location_id = $request->country;
            $query->where('co.location_id', '=', $location_id);

        }

        if (isset($request->category) && !is_null($request->category)) {
            $query
                ->where('jo.category_id', '=', $request->category);
        }

        $jobType = [];

        if (isset($request->freelance)) {
            $jobType[] = 'freelance';
        }

        if (isset($request->full_time)) {
            $jobType[] = 'Full Time';
        }

        if (isset($request->full_time)) {
            $jobType[] = 'Full Time';
        }

        if (isset($request->part_time)) {
            $jobType[] = 'Part Time';
        }

        if (isset($request->internship)) {
            $jobType[] = 'internship';
        }

        if (isset($request->temporary)) {
            $jobType[] = 'temporary';
        }

        if (!empty($jobType)) {
            $query->whereIn('jo.type', $jobType);
        }

        return $query;
    }

    /**
     * getRelatedJobs method.
     * Fetches related jobs
     * Fetches on :
     *  - Job Type
     *  Or
     *  - Job Category
     * @param mixed $job Reference job.
     * @return mixed
     */
    public static function getRelatedJobs($job)
    {
        $relatedJobs = DB::table('jobs as jo')
            ->join('companies as co', 'co.id', '=', 'jo.company_id')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->join('categories as cat', 'cat.id', '=', 'jo.category_id')
            ->select('jo.id',
                'jo.slug',
                'jo.title',
                'jo.type',
                'jo.salary_low',
                'jo.salary_high',
                'cat.name',
                DB::raw('DATEDIFF(jo.created_at, NOW()) as date_posted'),
                'co.name',
                'co.verified',
                'co.pic_url',
                'lo.country_name')
            ->where('jo.type', '=', $job->type)
            ->orWhere('jo.category_id', '=', $job->category_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        self::removeDashesFromDates($relatedJobs);
        self::getSalaryInThousands($relatedJobs);

        return $relatedJobs;
    }

    /**
     * removeDashesFromDates method.
     * Removes the dash from the date generated by the DATEDIFF() func. from MYSQL.
     * @param $jobs
     * @return mixed
     */
    public static function removeDashesFromDates($jobs)
    {
        // If $jobs is a single entity (result of method : getAllDataOfJob())
        if (!is_countable($jobs)) {
            $jobs->date_posted = str_replace('-', '', $jobs->date_posted);
        } else {
            foreach ($jobs as $job) {
                $job->date_posted = str_replace('-', '', $job->date_posted);
            }
        }

        return $jobs;
    }

    /**
     * getSalaryInThousands method.
     * Formats salaries values in thousands.
     * @param $jobs
     * @return mixed
     */
    public static function getSalaryInThousands($jobs)
    {
        if (!is_countable($jobs)) {
            $jobs->salary_low = floor($jobs->salary_low / 1000) * 1000;
            $jobs->salary_high = ceil($jobs->salary_high / 1000) * 1000;
        } else {
            foreach ($jobs as $job) {
                $job->salary_low = floor($job->salary_low / 1000) * 1000;
                $job->salary_high = ceil($job->salary_high / 1000) * 1000;
            }
        }

        return $jobs;
    }
}
