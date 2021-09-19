<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class Welcome extends Model
{
    use HasFactory;

    /**
     * getFeaturedJobs method.
     * Retrieves a random set of featured jobs.
     *
     * @return Collection
     */
    public static function getFeaturedJobs(): Collection
    {
        $featuredJobs = DB::table('jobs as jo')
            ->select('jo.id',
                'jo.title',
                'jo.slug',
                DB::raw('DATEDIFF(jo.created_at, NOW()) as date_posted'),
                'jo.type',
                'co.name as company',
                'co.pic_url as pic',
                'lo.country_name as country')
            ->join('companies as co', 'co.id', '=', 'jo.id')
            ->join('locations as lo', 'co.location_id', '=', 'lo.id')
            ->where('featured', '=', 1)
            ->where('open', '=', 1)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return self::removeDashesFromDates($featuredJobs);
    }

    /**
     * getFeaturedFreelancers method.
     * Retrieves a random set of featured freelancers.
     * Featured = A freelancer who paid for a premium plan
     *
     * @return Collection
     */
    public static function getFeaturedFreelancers(): Collection
    {
        return DB::table('users as u')
            ->select(DB::raw('DISTINCT fr.id'),
                'fr.pic_url',
                'fr.verified',
                DB::raw("CONCAT(fr.firstname, ' ', fr.lastname) as fullName"),
                'lo.country_code',
                'cat.name as speciality',
                'lo.country_name',
                'fr.hourly_rate',
                'fr.success_rate',
                'u.dir_url')
            ->join('freelancers as fr', 'fr.id', '=', 'u.id')
            ->join('categories as cat', 'cat.id', '=', 'fr.category_id')
            ->join('locations as lo', 'lo.id', '=', 'fr.location_id')
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

    /**
     * removeDashesFromDates method.
     * Removes the dash from the date generated by the DATEDIFF() func. from MYSQL.
     *
     * @param Collection $featuredJobs
     *
     * @return Collection
     */
    public static function removeDashesFromDates(Collection $featuredJobs): Collection
    {
        foreach ($featuredJobs as $job) {
            $job->date_posted = str_replace('-', '', $job->date_posted);
        }

        return $featuredJobs;
    }

    /**
     * getCountJobsCategories method.
     *
     * Retrieves the total amount of jobs per category
     */
    public static function getCountJobsCategories($categories)
    {
        foreach ($categories as $category) {
            $category->jobCount = DB::table('jobs as jo')
                ->select(
                    DB::raw('COUNT(jo.id) as amount')
                )->where('jo.category_id', '=', $category->id)
                ->first()
                ->amount;
        }

        return $categories;
    }

    /**
     * getRecentTasks method.
     * Retrieves 4 tasks recently submitted
     *
     * @return Collection
     */
    public static function getRecentTasks(): Collection
    {
        $tasks = DB::table('tasks as ta')
            ->select('ta.id',
                'ta.name',
                'ta.budget_min',
                'ta.budget_max',
                'ta.type',
                DB::raw('DATEDIFF(NOW(), ta.created_at) as task_created_at'),
                'ta.employer_id',
                'ta.category_id',
                'lo.country_name as country',
                'co.id as company_id',
                'skta.skills')
            ->join('companies as co', 'co.id', '=', 'ta.employer_id')
            ->join('locations as lo', 'lo.id', '=', 'co.location_id')
            ->join('skills_tasks as skta', 'skta.task_id', '=', 'ta.id')
            ->limit(4)
            ->orderBy('task_created_at')
            ->get();

        foreach ($tasks as $task) {
            if (is_null($task->skills)) {
                $task->skills = ['None'];
            } else {
                // Turns the skills string into an array
                $task->skills = Controller::curateSkills($task->skills);
            }
        }

        return $tasks;
    }

    /**
     * searchJobsOrTasks method.
     * Handles the search request from the homepage
     *
     * @param Request $request
     * @param string  $jobOrTask
     *
     * @return LengthAwarePaginator
     */
    public static function searchJobsOrTasks(Request $request, string $jobOrTask): LengthAwarePaginator
    {
        if (!is_null($request->searchCountry)) {

            $locationId = self::checkIfLocationExists($request->searchCountry);

            if (!is_null($locationId)) {
                if ($jobOrTask === 'task') {
                    $request->request->add(['task_country' => $locationId]);
                }

                $request->request->add(['country' => $locationId]);
            }
        }

        if ($jobOrTask === 'task') {
            $request->request->add(['task_category' => $request->category]);
        }

        if (!is_null($request->type)) {
            self::setType($request);

        }

        if ($jobOrTask === 'job') {
            return Job::getAllJobsAndCompanyInfo($request, false, true);
        }

        return Task::getTasks($request);
    }

    /**
     * checkIfLocationExists method.
     * Checks if the location requested by the user exists in the DDB.
     *
     * @param string $location
     *
     * @return mixed|void
     */
    private static function checkIfLocationExists(string $location)
    {
        $location = DB::table('locations as lo')
            ->select('id')
            ->where('country_name', 'LIKE', '%' . $location . '%')
            ->first();

        if (!is_null($location)) {
            return $location->id;
        }
    }

    /**
     * checkIfCategoryExists method.
     * Checks if the category requested by the user exists in the DDB
     *
     * @param string $categoryId
     *
     * @return mixed
     */
    private static function checkIfCategoryExists(string $categoryId)
    {
        return DB::table('categories as cat')
            ->select('id')
            ->where('cat.id', '=', $categoryId)
            ->first();
    }

    private static function setType($request)
    {
        switch ($request->type) {
            case 'freelance':
                return $request->request->add(['freelance' => 'on']);
            case 'full-time':
                return $request->request->add(['full_time' => 'on']);
            case 'part-time':
                return $request->request->add(['part_time' => 'on']);
            case 'internship':
                return $request->request->add(['internship' => 'on']);
            case 'fixed':
                return $request->type = 'fixed';
            case 'hourly':
                return $request->type = 'hourly';
        }

        return false;
    }

    public static function isTaskOrJob($request)
    {
        $jobTypes = [
            'freelance',
            'full-time',
            'part-time',
            'internship'
        ];

        $taskTypes = [
            'fixed',
            'hourly'
        ];

        $searchIsJob = in_array($request->type, $jobTypes, true);
        $searchIsTask = in_array($request->type, $taskTypes, true);

        if ($searchIsJob) {
            return 'job';
        }

        if ($searchIsTask) {
            return 'task';
        }

        return false;
    }
}
