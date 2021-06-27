<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'name',
        'description',
        'verified',
        'pic_url',
    ];

    /**
     * Relation Company -> User
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getFirstSetOfCompanies(): LengthAwarePaginator
    {
        $companies = DB::table('companies as co')
            ->select('co.id',
                'co.slug',
                'co.name',
                'co.verified',
                'co.pic_url')
            ->where('co.name', 'like', 'A%')
            ->paginate(6);

        foreach ($companies as $company) {
            $company->rating = self::getCompanyRating($company->id);
        }

        return $companies;
    }

    // TODO: in company@index, add sort method (rating ?)

    /**
     * Searches all companies starting with a specific letter
     * @param string $letter
     * @return LengthAwarePaginator
     * @see company@index
     */
    public static function searchCompaniesByLetter(string $letter): LengthAwarePaginator
    {
        $companies = DB::table('companies as co')
            ->select('co.id',
                'co.slug',
                'co.name',
                'co.verified',
                'co.pic_url')
            ->where('co.name', 'like', $letter . '%')
            ->paginate(6);

        foreach ($companies as $company) {
            $company->rating = self::getCompanyRating($company->id);
        }

        return $companies;
    }

    /**
     * getCompanyInfo method.
     * Fetches the information of a company
     * @param $company_id
     * @return Model|Builder|object|null
     */
    public static function getCompanyInfo($company_id)
    {
        $company = DB::table('companies as co')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->select('co.*', 'lo.country_name', 'lo.country_code')
            ->where('co.id', '=', $company_id)
            ->first();


        $company->rating = self::getCompanyRating($company_id);

        return $company;
    }

    /**
     * getCompanyRating method.
     * Gets the ratings of a company
     * @param $company_id
     * @return float|int
     */
    public static function getCompanyRating($company_id) {
        $ratings = DB::table('ratings_companies as rc')
            ->select('rc.note')
            ->where('rc.company_id', '=', $company_id)
            ->get();

        $total = 0;

        foreach($ratings as $rating) {
            $total += $rating->note;
        }

        return round($total / count($ratings), 1);
    }

    /**
     * getOpenPositionsOfCompany method.
     * Fetches a set of randomized jobs from a specific company
     * @param int $company_id
     * @return Collection
     */
    public static function getOpenPositions(int $company_id): Collection
    {
        $positions =  DB::table('jobs as jo')
            ->join('categories as ca', 'ca.id', '=', 'jo.category_id')
            ->join('companies as co', 'co.id', '=', 'jo.company_id')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->select(
                'jo.id',
                'jo.title',
                'jo.slug',
                'jo.type',
                'lo.country_name',
                DB::raw('DATEDIFF(jo.created_at, NOW()) AS date_posted'),
                'ca.name'
            )
            ->where('jo.open', '=', 1)
            ->where('jo.company_id', '=', $company_id)
            ->get();

        self::removeDashesFromJobs($positions);

        return $positions;
    }

    /**
     * getOpenTasks method.
     * Gets the tasks that have the opened status
     * @param int $company_id
     * @return Collection
     */
    public static function getOpenTasks(int $company_id): Collection
    {
        $tasks = DB::table('tasks')
            ->join('categories as ca', 'ca.id', '=', 'tasks.category_id')
            ->select('ca.id',
                'tasks.budget_min',
                'tasks.budget_max',
                'tasks.name',
                'tasks.type',
                'ca.name as category_name')
            ->where('tasks.employer_id', '=', $company_id)
            ->get();

        self::getBudgetInThousands($tasks);

        return $tasks;
    }

    /**
     * getRatings method.
     * Gets a set of ratings for a specific company
     * @param int $company_id
     * @param null $sortBy
     * @return Collection
     */
    public static function getRatings(int $company_id, $sortBy = null): Collection
    {
        $ratings = DB::table('ratings_companies as rc')
            ->join('freelancers as fr', 'fr.id', '=', 'rc.freelancer_id')
            ->join('users as u', 'u.id', '=', 'fr.user_id')
            ->select('rc.note',
                'rc.comment',
                DB::raw("CONCAT(u.firstname, ' ', u.lastname) AS full_name"),
                DB::raw("DATEDIFF(rc.when, NOW()) as rating_when"))
            ->where('rc.company_id', '=', $company_id)
            ->limit(5);

        if (!is_null($sortBy)) {
            $ratings = self::sortRatings($ratings, $sortBy);
        } else {
            $ratings->orderByDesc('rc.when');
        }

        $ratings = $ratings->get();

        self::removeDashesFromRatings($ratings);

        return $ratings;
    }

    /**
     * sortQuery method.
     * Sorts the list of ratings depending on user's request
     * @param $query
     * @param $sortBy
     * @return mixed
     */
    public static function sortRatings($query, $sortBy)
    {
        if (!is_null($sortBy)) {
            if ($sortBy === 'newest') {
                $query->orderByDesc('rc.when');
            }

            if ($sortBy === 'oldest') {
                $query->orderBy('rc.when');
            }

            if ($sortBy === 'high-to-low') {
                $query->orderByDesc('rc.note');
            }

            if ($sortBy === 'low-to-high') {
                $query->orderBy('rc.note');
            }
        }

        return $query;
    }

    /**
     * removeDashesFromDates method.
     * Removes the dash from the date generated by the DATEDIFF() func. from MYSQL.
     * @param Collection $positions
     * @return Collection
     */
    private static function removeDashesFromJobs(Collection $positions): Collection
    {
        // If $positions is a single entity
        if (!is_countable($positions)) {
            $positions->date_posted = str_replace('-', '', $positions->date_posted);
        } else {
            foreach ($positions as $position) {
                $position->date_posted = str_replace('-', '', $position->date_posted);
            }
        }

        return $positions;
    }

    /**
     * removeDashesFromRatings method.
     * Removes the dash from the date generated by the DATEDIFF() func. from MYSQL.
     * @param Collection $ratings
     * @return Collection
     */
    private static function removeDashesFromRatings(Collection $ratings): Collection
    {

        if (!is_countable($ratings)) {

            $ratings->rating_when = str_replace('-', '', $ratings->rating_when);
        } else {

            foreach ($ratings as $rating) {
                $rating->rating_when = str_replace('-', '', $rating->rating_when);
            }
        }

        return $ratings;
    }

    /**
     * getBudgetInThousands method.
     * Formats the budget values of tasks in thousands.
     * @param Collection $collection
     * @return Collection
     */
    private static function getBudgetInThousands(Collection $collection): Collection
    {
        if (!is_countable($collection)) {
            $collection->budget_min = floor($collection->budget_min / 1000) * 1000;
            $collection->budget_max = ceil($collection->budget_max / 1000) * 1000;
        } else {
            foreach ($collection as $item) {
                $item->budget_min = floor($item->budget_min / 1000) * 1000;
                $item->budget_max = ceil($item->budget_max / 1000) * 1000;
            }
        }

        return $collection;
    }
}
