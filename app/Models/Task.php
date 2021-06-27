<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'description',
        'budget_min',
        'budget_max',
        'type',
        'due_date',
        'name',
    ];

    /**
     * Relation Task -> Company
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation Task -> Category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * getTasks method.
     * Gets all tasks and returns it, paginated.
     * @param Request|null $request if $sort, gets the sort method from the Request
     * @param bool $sort to sort the query or not
     * @return LengthAwarePaginator $tasks
     */
    public static function getTasks(Request $request = null, bool $sort = false): LengthAwarePaginator
    {
        $query =  DB::table('tasks as ta')
            ->select(
                'ta.*',
                DB::raw('DATEDIFF(ta.created_at, NOW()) as date_posted'),
                DB::raw('DATEDIFF(ta.due_date, NOW()) as end_date')
            );

        if (!empty($request && !$sort)) {
            $query = self::searchTasks($query, $request);
        }

        if ($sort && !empty($request->sortBy)) {
            $query = self::sortTasks($query, $request->sortBy);
        }

        $tasks = $query->paginate(4);

        foreach ($tasks as $task) {
            $task->company  = Company::where('id', '=', $task->employer_id)->first();
            $task->location = Location::where('id', '=', $task->company->location_id)->first();

            self::removeDashesFromDates($task);
        }

        return $tasks;
    }

    /**
     * getTaskInfo method.
     * Retrives data of the corresponding task
     * @param int $id Task id
     * @return Model|Builder|object|null
     */
    public static function getTaskInfo(int $id)
    {
        return DB::table('tasks as ta')
            ->join('companies as co', 'co.id', '=', 'ta.employer_id')
            ->select(
                'ta.*',
                DB::raw('DATEDIFF(ta.due_date, NOW()) as end_date'),
                'co.id as company_id',
                'co.name as company_name',
                'co.location_id',
                'co.slug as company_slug',
                'co.verified',
                'co.pic_url'
            )
            ->where('ta.id', '=', $id)
            ->first();
    }

    /**
     * searchTasks method.
     * Searches through all tasks depending on the request's data.
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    private static function searchTasks(Builder $query, Request $request): Builder
    {
        $DBFixedRates   = self::getFixedRatesLimits();
        $DBHourlyRates  = self::getHourlyRatesLimits();
        $sliderFixedRates = explode(',', $request->fixed_price);
        $sliderHourlyRates = explode(',', $request->hourly_rate);

        if (!is_null($request->task_country)) {
            $query->join('companies as co', 'co.id', '=', 'ta.employer_id')
                ->where('co.location_id', '=', $request->task_country);
        }

        if (!is_null($request->task_category)) {
            $query->where('ta.category_id', '=', $request->task_category);
        }

        if (!is_null($request->skills)) {
            $query->join('skills_tasks as st', 'st.task_id', '=', 'ta.id');

            foreach($request->skills as $skill) {
                $query->where('st.skills', 'like', '%' . $skill . '%');
            }
        }

        if ($sliderFixedRates[0] > $DBFixedRates->min_rate || $sliderFixedRates[1] < $DBFixedRates->max_rate) {
            $query->where('ta.type', '=', 'Fixed')
                ->where('ta.budget_min', '>=', $sliderFixedRates[0])
                ->where('ta.budget_max', '<=', $sliderFixedRates[1]);
        }

        if ($sliderHourlyRates[0] > $DBHourlyRates->min_rate || $sliderHourlyRates[1] < $DBHourlyRates->max_rate) {
            $query->where('ta.type', '=', 'Hourly')
                ->where('budget_min', '>=', $sliderHourlyRates[0])
                ->where('budget_max', '<=', $sliderHourlyRates[1]);
        }

        return $query;
    }

    /**
     * sortTasks method.
     * Sorts the list of tasks depending on user's request
     * @param Builder $query
     * @param string $sortByMethod Random|Newest|Oldest
     * @return Builder
     */
    private static function sortTasks(Builder $query, string $sortByMethod): Builder
    {
        if (!is_null($sortByMethod)) {
            if ($sortByMethod === 'random') {
                $query->inRandomOrder();
            }

            if ($sortByMethod === 'newest') {
                $query->orderBy('ta.created_at', 'desc');
            }

            if ($sortByMethod === 'oldest') {
                $query->orderBy('ta.created_at');
            }

            // End date soon
            if ($sortByMethod === 'soon') {
                $query->where('ta.due_date', '>', now())
                    ->whereRaw('ta.due_date < CURDATE() + INTERVAL 7 DAY');
            }

            // End date late
            if ($sortByMethod === 'later') {
                $query->orderBy('ta.due_date', 'desc');
            }

            // Highest paying
            if ($sortByMethod === 'remunHigh') {
                $query->orderBy('ta.budget_max', 'desc');
            }

            // Lowest paying
            if ($sortByMethod === 'remunLow') {
                $query->orderBy('ta.budget_max');
            }
        }

        return $query;
    }

    /**
     * getMaxFixedRate method.
     * Returns the highest Fixed Rate (tasks.budget_max)
     * -> to populate Fixed Price slider
     */
    public static function getFixedRatesLimits()
    {
        return DB::table('tasks as ta')
            ->selectRaw('MAX(ta.budget_max) as max_rate')
            ->selectRaw('MIN(ta.budget_min) as min_rate')
            ->where('ta.type', '=', 'Fixed')
            ->first();
    }

    /**
     * getHourlyRatesLimits method.
     * Returns the highest Hourly Rate (tasks.budget_max)
     * -> to populate Hourly Rate slider
     */
    public static function getHourlyRatesLimits()
    {
        return DB::table('tasks as ta')
            ->selectRaw('MAX(ta.budget_max) as max_rate')
            ->selectRaw('MIN(ta.budget_min) as min_rate')
            ->where('ta.type', '=', 'Hourly')
            ->first();
    }

    /**
     * getSkills method.
     * Retrieves the skills linked to the task
     * Strips every skill of any unwanted character such as :
     *  -> "
     *  -> [
     *  -> ]
     *
     * @param int $id task id
     * @return array
     */
    public static function getSkills(int $id): array
    {
        $skills = DB::table('skills_tasks as st')
            ->select('st.skills')
            ->where('st.task_id', '=', $id)
            ->first()
            ->skills;

        return self::curateSkills(explode(',', $skills));
    }

    /**
     * curateSkills method.
     * Strips the ", [ and ] from the skills strings.
     * @param array $skills
     * @return array
     */
    private static function curateSkills(array $skills): array
    {
        $curatedArrSkills = [];

        foreach($skills as $skill) {
            $curatedArrSkills[] = preg_replace('/[\W\b]/','', $skill);
        }

        return $curatedArrSkills;
    }

    /**
     * removeDashesFromDates method.
     * Removes the dash from the date generated by the DATEDIFF() func. from MYSQL.
     * @param $task
     * @return mixed
     */
    private static function removeDashesFromDates($task)
    {
        $task->due_date = str_replace('-', '', $task->date_posted);
        $task->end_date = str_replace('-', '', $task->end_date);

        return $task;
    }
}
