<?php
    
    namespace App\Http\Controllers;
    
    use App\Mail\ContactForm;
    use App\Models\Category;
    use App\Models\Location;
    use App\Models\Task;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request as Request;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Str;
    
    class Controller extends BaseController
    {
        use DispatchesJobs;
        use ValidatesRequests;
        use AuthorizesRequests;
        
        /**
         * curateSkills method.
         * Strips the ", [ and ] from the skills strings.
         *
         * @param string $skillsSet
         *
         * @return array
         */
        public static function curateSkills (string $skillsSet) : array
        {
            
            $skills = explode(',', $skillsSet);
            
            $curatedArrSkills = [];
            
            foreach ($skills as $skill) {
                $curatedArrSkills[] = preg_replace('/[\W\b]/', '', $skill);
            }
            
            return $curatedArrSkills;
        }
        
        /**
         * curateSignInDate method.
         *
         * Strips the '-' character from the string
         * Outputs the number of days / years since the member has joined the platform
         *
         * @param string $days
         *
         * @return string
         */
        public static function curateSignInDate (string $days) : string
        {
            $amountDays = substr($days, 1);
            $daysPerYear = 365;
            
            if (empty($amountDays)) {
                return '0 day';
            }
            if ($amountDays > 364) {
                for ($i = 1; $i <= 5; $i++) {
                    // If $amountDays between 365 * $i and 365 * $i + 1
                    if ($amountDays >= ($daysPerYear * $i) && $amountDays < ($daysPerYear * ($i + 1))) {
                        return $i > 1
                            ? $i . ' years'
                            : $i . ' year';
                    }
                    
                    if ($i === 5 && $amountDays >= ($daysPerYear * $i + 1)) {
                        return $i + 1 . '+ years';
                    }
                }
            }
            
            return $amountDays > 1
                ? $amountDays . ' days'
                : $amountDays . ' day';
        }
        
        /**
         * Handles the contact form and sends a mail to the website's email address
         *
         * @param Request $request
         *
         * @throws \Illuminate\Validation\ValidationException
         */
        public function sendContactForm (Request $request) : \Illuminate\Http\RedirectResponse
        {
            $this->validate($request, [
                'name'    => 'required',
                'email'   => 'required|email',
                'subject' => 'required',
                'message' => 'required'
            ]);
            
            $details = [
                'name'    => $request->name,
                'email'   => $request->email,
                'message' => $request->message,
                'subject' => $request->subject
            ];
            
            Mail::to(env('MAIL_FROM_ADDRESS'))
                ->send(new ContactForm($details));
            
            return back()->with('success', 'Thanks for contacting us !');
        }
        
        /**
         * @method getTasksDetails
         * @param LengthAwarePaginator $tasks
         *
         * @return Application|Factory|View
         */
        public static function getTasksDetails (LengthAwarePaginator $tasks)
        {
            foreach ($tasks as $task) {
                $task->skills = Task::getSkills($task->id);
            }
            
            $fixedRates = Task::getFixedRatesLimits();
            $hourlyRates = Task::getHourlyRatesLimits();
            $categories = Category::all(['id', 'name']);
            $locations = Location::all(['id', 'country_name']);
            $skills = DB::table('skills')->get('skill');
            
            return view('task.index', compact([
                'tasks',
                'categories',
                'locations',
                'skills',
                'fixedRates',
                'hourlyRates'
            ]));
        }
        
        /**
         * @method resourceExists
         * Looks up for a match for a job/task with a given id and a slug
         *
         * @param string $contentType The kind of content has been requested
         * @param int    $id
         * @param string $slug
         *
         * @return bool true if a match has been found, false otherwise.
         */
        public static function resourceExists (string $contentType, int $id, string $slug) : bool
        {
            $query = null;
            $match = null;
            
            if (in_array($contentType, ['job', 'task', 'company'])) {
                if ($contentType === 'job') {
                    $query = DB::table('jobs');
                }
                
                if ($contentType === 'task') {
                    $query = DB::table('tasks');
                }
                
                if ($contentType === 'company') {
                    $query = DB::table('companies');
                }
                
                $match = $query
                    ->select('id')
                    ->where('id', '=', $id)
                    ->where('slug', 'LIKE', '%' . $slug . '%')
                    ->get();
            }
            elseif ($contentType === 'freelancer') {
                $freelancer = DB::table('freelancers as fr')
                    ->select('fr.id', 'fr.firstname', 'fr.lastname')
                    ->where('fr.id', '=', $id)
                    ->first();
                
                if (!is_null($freelancer->id)) {
                    $isCorrectSlug = Str::slug($freelancer->firstname . ' ' . $freelancer->lastname) === $slug;
                    
                    if ($isCorrectSlug) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                
                return false;
            } elseif ($contentType === 'category') {
                $category = DB::table('categories')
                    ->select('id')
                    ->where('id', '=', $id)
                    ->first();
                
                if (is_null($category) || is_null($category->id)) {
                    return false;
                }
                
                return true;
            }
            
            return sizeof($match) > 0;
        }
    }