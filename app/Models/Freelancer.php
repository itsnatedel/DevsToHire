<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Freelancer extends Model
{
    // TODO: Make Offer in freelancer@view
    use HasFactory;

    protected $table = 'freelancers';
    protected $fillable = [
        'description',
        'pic_url',
        'hourly_rate',
        'CV_url',
        'firstname',
        'lastname',
        'description',
    ];

    /**
     * getFreelancersInfos method.
     * Retrieves the informations needed for the Freelancer@index view.
     * TODO: Number of freelancer =\= total freelancers in Freelancer@index && Homepage ?
     */
    public static function getFreelancersInfos(Request $request = null, $sort = null): LengthAwarePaginator
    {
        $freelancers = DB::table('freelancers as fr')
            ->join('locations as lo', 'lo.id', '=', 'fr.location_id')
            ->join('ratings_freelancers as rfr', 'rfr.freelancer_id', '=', 'fr.id')
            ->join('categories as cat', 'cat.id', '=', 'fr.category_id')
            ->join('freelancer_jobs_done as frjb', 'frjb.freelancer_id', '=', 'fr.id')
            ->select(
                'fr.id',
                DB::raw("CONCAT(fr.firstname, ' ', fr.lastname) as full_name"),
                DB::raw('SUM(rfr.note) / COUNT(rfr.id) as rating'),
                'fr.pic_url',
                'cat.name as specialization',
                'fr.verified',
                'fr.hourly_rate',
                DB::raw('SUM(IF(frjb.success = 1, 1, 0)) / COUNT(frjb.id) as success_rate'),
                DB::raw('SUM(IF(frjb.recommended = 1, 1, 0)) / COUNT(frjb.id) as recommended'),
                'lo.country_code',
                'lo.country_name',
            )->groupBy('fr.id');

        if (!is_null($request) && is_null($sort)) {
            $freelancers = self::refinedSearch($request, $freelancers);
        }

        if ($sort) {
            self::sortFreelancers($request->sortOption, $freelancers);
        } else {
            $freelancers->inRandomOrder();
        }

        return $freelancers->paginate(8);
    }

    /**
     * refinedSearch method.
     *
     * Searches for freelancers that meet the search criterias.
     *
     * @param Request $request
     * @param Builder $freelancers
     *
     * @return Builder
     */
    private static function refinedSearch(Request $request, Builder $freelancers): Builder
    {
        if (!is_null($request->country)) {
            $freelancers->where('lo.country_name', '=', $request->country);
        }

        if (!is_null($request->specialization)) {
            $freelancers->where('cat.name', '=', $request->specialization);
        }

        if (!is_null($request->skill)) {
            $freelancers->join('skills_freelancers as skfr', 'skfr.freelancer_id', '=', 'fr.id')
                ->where('skfr.skills', 'like', '%' . $request->skill . '%');
        }

        // Sliders search
        if (!is_null($request->hourlyRates)
            && !is_null($request->successRates)
            && !is_null($request->rated)) {
            $hourlyRates = explode(',', $request->hourlyRates);
            $freelancers->whereBetween('fr.hourly_rate', $hourlyRates);

            $freelancers->where('fr.success_rate', '>=', $request->successRates);
            $freelancers->having(DB::raw('SUM(rfr.note) / COUNT(rfr.id)'), '>=', $request->rated);
        }

        return $freelancers;
    }

    /**
     * sortFreelancers method.
     *
     * Sorts the freelancers by a given option
     *
     * @param string  $sortOption
     * @param Builder $freelancers
     *
     * @return Builder
     */
    private static function sortFreelancers(string $sortOption, Builder $freelancers): Builder
    {
        if ($sortOption === 'jobHiLo') {
            $freelancers->orderByDesc('success_rate');
        }

        if ($sortOption === 'jobLoHi') {
            $freelancers->orderBy('success_rate');
        }

        if ($sortOption === 'ratingHiLo') {
            $freelancers->orderByDesc('rating');
        }

        if ($sortOption === 'ratingLoHi') {
            $freelancers->orderBy('rating');
        }

        if ($sortOption === 'hrHiLo') {
            $freelancers->orderByDesc('hourly_rate');
        }

        if ($sortOption === 'hrLoHi') {
            $freelancers->orderBy('hourly_rate');
        }

        if ($sortOption === 'random') {
            $freelancers->inRandomOrder();
        }

        return $freelancers;
    }

    /**
     * getHourlyRateLimits method.
     * Get the min & max value of the freelancers' hourly rates.
     */
    public static function getHourlyRateLimits()
    {
        return DB::table('freelancers as fr')
            ->selectRaw('MAX(fr.hourly_rate) as max_rate')
            ->selectRaw('MIN(fr.hourly_rate) as min_rate')
            ->first();
    }

    /**
     * getSuccessRateLimits method.
     * Gets the min & max value of the freelancers' success rates.
     */
    public static function getSuccessRateLimits()
    {
        return DB::table('freelancers as fr')
            ->selectRaw('MAX(fr.success_rate) as max_rate')
            ->selectRaw('MIN(fr.success_rate) as min_rate')
            ->first();
    }

    /**
     * getFreelancerSkills method.
     *
     * Returns the Freelancer's main skills
     *
     * @param int $id
     *
     * @return array
     */
    public static function getFreelancerSkills(int $id): array
    {
        $skillsSet = DB::table('skills_freelancers')
            ->select('skills')
            ->where('freelancer_id', '=', $id)
            ->first();

        return is_null($skillsSet)
            ? ['None']
            : Controller::curateSkills($skillsSet->skills);

    }

    /**
     * getSingleFreelancerInfos method.
     * Retrieves data used to populate a freelancer profile
     * @param int $id Freelancer id
     *
     * @return Model|Builder|object|null
     */
    public static function getSingleFreelancerInfos(int $id)
    {
        $freelancer = DB::table('freelancers as fr')
            ->join('locations as lo', 'lo.id', '=', 'fr.location_id')
            ->join('categories as cat', 'cat.id', '=', 'fr.category_id')
            ->select(
                DB::raw('DATEDIFF(fr.joined_at, NOW()) as joined_at'),
                'lo.country_name',
                'lo.country_code',
                'cat.name as speciality'
            )
            ->where('fr.id', '=', $id)
            ->first();

        $freelancer->stats = self::getFreelancerStats($id);
        $freelancer->joined_at = Controller::curateSignInDate($freelancer->joined_at);

        return $freelancer;
    }

    /**
     * getFreelancerStats method.
     * Retrieves some statistics of a freelancer.
     *
     * @param int $id Freelancer id
     *
     * @return object
     */
    private static function getFreelancerStats(int $id): object
    {
        $stats = DB::table('freelancer_jobs_done as frjb')
            ->join('ratings_freelancers as rfr', 'rfr.freelancer_id', '=', 'frjb.freelancer_id')
            ->select(
                DB::raw('SUM(IF(frjb.on_time = 1, 1, 0)) / COUNT(frjb.id) as on_time'),
                DB::raw('SUM(IF(frjb.on_budget = 1, 1, 0)) / COUNT(frjb.id) as on_budget'),
                DB::raw('SUM(IF(frjb.recommended = 1, 1, 0)) / COUNT(frjb.id) as recommended'),
                DB::raw('SUM(IF(frjb.success = 1, 1, 0)) / COUNT(frjb.id) as success'),
                DB::raw('COUNT(frjb.id) as total'),
                DB::raw('SUM(rfr.note) / COUNT(rfr.id) as rating'))
            ->where('frjb.freelancer_id', '=', $id)
            ->first();

        // Get percentages of fetched values
        $stats->on_time *= 100;
        $stats->on_budget *= 100;
        $stats->recommended *= 100;
        $stats->success *= 100;

        return $stats;
    }

    /**
     * getSingleFreelancerJobs method.
     *
     * Retrieves the jobs done by a freelancer
     *
     * @param int $id Freelancer id
     *
     * @return Collection
     */
    public static function getSingleFreelancerJobs(int $id): Collection
    {
        return DB::table('freelancer_jobs_done as fjd')
            ->join('companies as co', 'co.id', '=', 'fjd.employer_id')
            ->select(
                'fjd.title',
                'fjd.comment',
                'fjd.rating',
                DB::raw('DATE_FORMAT(fjd.done_at, "%M %Y") as done_at'),
                'co.id as company_id',
                'co.name',
                'co.verified',
                'co.pic_url'
            )
            ->where('fjd.freelancer_id', '=', $id)
            ->get();
    }

    /**
     * Relation Freelancer -> Bid
     *
     * @return HasMany
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Relation Freelancer -> User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}