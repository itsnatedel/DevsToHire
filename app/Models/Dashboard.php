<?php
    
    namespace App\Models;
    
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreJobRequest;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Filesystem\Filesystem;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;
    use Intervention\Image\Facades\Image;
    use Ramsey\Uuid\Uuid;
    use RuntimeException;

    class Dashboard extends Model
    {
        use HasFactory;
        
        /**
         * @param User $user
         *
         * @return User
         */
        public static function getUserSettings (User $user) : User
        {
            if ($user->role_id === 2) {
                $user->stats = DB::table('freelancers as fr')
                    ->select('fr.description',
                        'fr.CV_url',
                        'fr.hourly_rate',
                        'cat.name as specialization')
                    ->join('categories as cat', 'cat.id', '=', 'fr.category_id')
                    ->where('fr.id', '=', $user->freelancer_id)
                    ->first();
                
                $user->skills = Freelancer::getFreelancerSkills($user->freelancer_id);
            }
            
            if ($user->role_id === 3) {
                $user->company = DB::table('companies as co')
                    ->select([
                        'co.name',
                        'co.description',
                        'co.speciality'
                    ])->where('co.user_id', '=', $user->id)
                    ->first();
            }
            
            return $user;
        }
        
        /**
         * checkAndUpdateSettings method.
         * Checks if the user has sent a different value on a field than what's on the DDB.
         * Updates those fields if changed.
         *
         * @param array $request The validated fields from the request
         * @param User  $user
         *
         * @return RedirectResponse|bool
         */
        public static function checkAndUpdateSettings (array $request, User $user)
        {
            $baseUserQuery = DB::table('users as u')
                ->where('u.id', $user->id);
            
            // Start the update with User's table fields
            $userUpdated = self::updateUsersSettings($baseUserQuery, $request, $user);
            $freelancerUpdate = false;
            $employerUpdate = false;
            
            if ($userUpdated) {
                if ($user->role_id === 2) {
                    $baseFreelancerQuery = DB::table('freelancers as fr')
                        ->where('fr.id', $user->freelancer_id);
                    
                    $freelancer = Freelancer::where('id', $user->freelancer_id)->first();
                    
                    $freelancerUpdate = self::updateFreelancerSettings($baseFreelancerQuery, $request, $freelancer);
                }
                
                if ($user->role_id === 3) {
                    $baseEmployerQuery = DB::table('companies as co')
                        ->where('co.id', $user->company_id);
                    
                    $employer = Company::where('id', $user->company_id)->first();
                    
                    $employerUpdate = self::updateCompanySettings($baseEmployerQuery, $request, $employer);
                }
                
                if ($freelancerUpdate || $employerUpdate) {
                    // Upload files
                    if (app('request')->file('attachmentUpload')) {
                        self::handleFileUpload(app('request'), $user);
                    }
                    
                    if (app('request')->has('profilePic')) {
                        /**
                         * Fetch the user data once more as it might have a newly created dir_url
                         *
                         * @see handleFileUpload()
                         */
                        $user = User::where('id', Auth::id())->first();
                        $avatarDir = $_SERVER['DOCUMENT_ROOT'] . '/images/user/' . $user->dir_url . '/avatar/';
                        
                        // Clean avatar directory
                        $fs = new Filesystem();
                        $fs->cleanDirectory($avatarDir);
                        
                        $filename = time() . '.' . app('request')->file('profilePic')->extension();
                        $resizedImage = Image::make(app('request')->file('profilePic'))->resize(42, 42);
                        
                        if ($resizedImage
                            ->save(public_path('images/user/' . $user->dir_url . '/avatar/') . $filename)
                        ) {
                            DB::table('users')
                                ->where('id', $user->id)
                                ->update(['pic_url' => $filename]);
                        }
                    }
                }
                return true;
            }
            
            return back()->with('fail', 'Please make sure you entered the correct informations.');
        }
        
        /**
         * updateUserTableSettings method.
         * Updates the fields in the Users Table
         *
         * @param       $baseQuery
         * @param array $request
         * @param User  $user
         *
         * @return bool
         */
        private static function updateUsersSettings ($baseQuery, array $request, User $user) : bool
        {
            if (!is_null($request['firstname']) && $user->firstname !== $request['firstname']) {
                $baseQuery->update(['firstname' => $request['firstname']]);
            }
            
            if (!is_null($request['lastname']) && $user->lastname !== $request['lastname']) {
                $baseQuery->update(['lastname' => $request['lastname']]);
            }
            
            if (!is_null($request['email']) && $user->email !== $request['email']) {
                $baseQuery->update(['email' => $request['email']]);
            }
            
            // If the new password !== old stored password, proceed to update
            if (!is_null($request['currentPassword'])
                && !is_null($request['newPassword'])
                && !is_null($request['newPasswordConf'])
                && !Hash::check($request['newPassword'], $user->password)
                && $request['newPassword'] === $request['newPasswordConf']
            ) {
                if (Hash::check($request['currentPassword'], $user->password)) {
                    $baseQuery->update(['password' => $request['newPassword']]);
                }
                else {
                    return false;
                }
            }
            
            if ($user->location_id != $request['country']) {
                $baseQuery->update(['location_id' => $request['country']]);
            }
            
            return true;
        }
        
        /**
         * updateFreelancersTableSettings method.
         * Updates the fields in the Freelancers Table
         *
         * @param            $baseQuery
         * @param array      $request
         * @param Freelancer $freelancer
         *
         * @return bool
         */
        private static function updateFreelancerSettings ($baseQuery, array $request, Freelancer $freelancer) : bool
        {
            // No need to check if those fields exists, already checked in updateUsersTableSettings method.
            if (!is_null($request['firstname'])
                && !is_null($request['lastname'])
            ) {
                $baseQuery->update(['firstname' => $request['firstname']]);
                $baseQuery->update(['lastname' => $request['lastname']]);
                $baseQuery->update(['location_id' => $request['country']]);
            }
            
            if ($freelancer->hourly_rate !== $request['sliderHourlyRate']) {
                $baseQuery->update(['hourly_rate' => (int)$request['sliderHourlyRate']]);
            }
            
            if ($freelancer->description !== $request['description']) {
                $baseQuery->update(['description' => $request['description']]);
            }
            
            if ($freelancer->category_id !== (int)$request['category']) {
                $baseQuery->update(['category_id' => (int)$request['category']]);
            }
            
            if (!is_null($request['skills'])) {
                DB::table('skills_freelancers')
                    ->updateOrInsert(
                        ['freelancer_id' => $freelancer->id],
                        ['skills' => json_encode([$request['skills']])]
                    );
            }
            
            return true;
        }
        
        /**
         * @method updateCompanySettings
         * Updates the data from the company
         *
         * @param Builder $baseEmployerQuery
         * @param array   $request
         * @param Company $employer
         *
         * @return bool
         */
        private static function updateCompanySettings (Builder $baseEmployerQuery, array $request, Company $employer) : bool
        {
            if (!is_null($request['companyName']) && ($employer->name !== $request['companyName'])) {
                $baseEmployerQuery->update([
                    'name' => $request['companyName'],
                    'slug' => Str::slug($request['companyName'])
                ]);
            }
            
            if (!is_null($request['speciality']) && ($employer->speciality !== $request['speciality'])) {
                $baseEmployerQuery->update(['speciality' => $request['speciality']]);
            }
            
            if (!is_null($request['description']) && ($employer->description !== $request['description'])) {
                $baseEmployerQuery->update(['description' => $request['description']]);
            }
            
            if (!is_null($request['country']) && ($employer->location_id != $request['country'])) {
                $baseEmployerQuery->update(['location_id' => (int)$request['country']]);
            }
            
            // pic url company logo
            
            return true;
        }
        
        /**
         * handleFileUpload method.
         * Uploads & store the CV/Contract files
         *
         * @param Request $request
         * @param User    $user
         *
         * @return bool
         */
        private static function handleFileUpload (Request $request, User $user) : bool
        {
            $filename = Uuid::uuid4() . '.' . $request->file('attachmentUpload')->extension();
            
            // Outside the if loop to keep the same value throughout the method
            $dirIdentifier = Str::slug(time() . date('Y-m-d H:i:s'));
            
            // The user has no directory
            if (is_null($user->dir_url)) {
                // Create directory to store user files
                $dirPath = $_SERVER['DOCUMENT_ROOT'] . '/images/user/' . $dirIdentifier;
                
                if (!is_dir($dirPath)) {
                    if (!mkdir($dirPath, 0755)) {
                        throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                    }
                }
                
                // Update user table to set the dir_url
                DB::table('users')
                    ->where('id', '=', Auth::id())
                    ->update(['dir_url' => $dirIdentifier]);
            }
            
            // If dir_url doesn't exist, use $dirIdentifier
            $userDir = $user->dir_url ?? $dirIdentifier;
            
            $filesDirPath = $_SERVER['DOCUMENT_ROOT'] . '/images/user/' . $userDir . '/files/';
            
            if (!is_dir($filesDirPath)) {
                if (!mkdir($filesDirPath, 0755)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $filesDirPath));
                }
            }
            
            // Uploading file
            $request->file('attachmentUpload')->move(public_path('images/user/' . $userDir . '/files/'), $filename);
            
            if ($user->role_id === 2) {
                DB::table('freelancers')
                    ->where('id', $user->freelancer_id)
                    ->update(['CV_url' => $filename]);
            }
            
            if ($user->role_id === 3) {
                DB::table('companies')
                    ->where('id', $user->company_id)
                    ->update(['contract_url' => $filename]);
            }
            
            return true;
        }
        
        /**
         * @method createJobOffer
         * Stores the job offer
         *
         * @param StoreJobRequest $request
         *
         * @return int
         */
        public static function createJobOffer (StoreJobRequest $request) : int
        {
            $isLocal = isset($request->locally) && $request->locally === 'on';
            
            $fileUrl = self::getFileUrl($request);
            self::storeJobFile($request, $fileUrl);
            
            return DB::table('jobs')
                ->insertGetId([
                    'title'        => $request->jobTitle,
                    'description'  => $request->description,
                    'salary_low'   => $request->salary_min,
                    'salary_high'  => $request->salary_max,
                    'remote'       => $request->remote,
                    'only_locally' => $isLocal,
                    'type'         => $request->jobType,
                    'company_id'   => $request->employerId ?? Auth::id(),
                    'category_id'  => $request->category,
                    'slug'         => Str::slug($request->jobTitle),
                    'location_id'  => $request->country,
                    'file_url'     => $fileUrl,
                    'created_at'   => Carbon::now()->toDateTimeString()
                ]);
        }
        
        /**
         * @method getFileUrl
         * Generates an UUID for the filename
         *
         * @param StoreJobRequest $request
         *
         * @return string
         */
        private static function getFileUrl (StoreJobRequest $request) : string
        {
            return Uuid::uuid4() . '.' . $request->file('projectFile')->extension();
        }
        
        /**
         * @method storeJobFile
         * Handles the upload of the job's file
         *
         * @param StoreJobRequest $request
         * @param string          $fileName
         *
         * @return bool
         */
        private static function storeJobFile (StoreJobRequest $request, string $fileName) : bool
        {
            $userDir = DB::table('users')
                ->select('dir_url')
                ->where('company_id', '=', $request->employerId)
                ->first()
                ->dir_url;
            
            $request->file('projectFile')->move(public_path('images/user/' . $userDir . '/files'), $fileName);
            
            return true;
        }
        
        /**
         * @method setJobSkills
         * Sets the skills requested for a job offer
         *
         * @param StoreJobRequest $request
         * @param int             $jobId
         *
         * @return bool
         */
        public static function setJobSkills (StoreJobRequest $request, int $jobId) : bool
        {
            return DB::table('skills_jobs')
                ->insert([
                    'skills'      => json_encode($request->skills),
                    'job_id'      => $jobId,
                    'employer_id' => $request->employerId ?? Auth::id()
                ]);
        }
        
        /**
         * @method getActiveJobs
         * Fetches all active job offers
         *
         * @param int $companyId
         *
         * @return Collection
         */
        public static function getActiveJobs (int $companyId) : Collection
        {
            $jobs = DB::table('jobs as jo')
                ->select([
                    'jo.id',
                    'jo.title',
                    'jo.slug',
                    'jo.salary_low',
                    'jo.salary_high',
                    'jo.type',
                    'jo.created_at',
                ])
                ->where('jo.company_id', '=', $companyId)
                ->get();
            
            return self::getAmountCandidates($jobs);
        }
        
        /**
         * @method getAmountCandidates
         * Counts the amount of candidates for each job
         *
         * @param Collection $jobs
         *
         * @return Collection
         */
        private static function getAmountCandidates (Collection $jobs) : Collection
        {
            foreach ($jobs as $job) {
                $job->candidates = DB::table('candidates')
                    ->select(DB::raw('COUNT(id) as count'))
                    ->where('job_id', '=', $job->id)
                    ->first()
                    ->count;
            }
            
            return $jobs;
        }
        
        /**
         * @method getAllJobsCandidates
         * Retrieves all active jobs offers and their candidates
         *
         * @param int $company_id
         *
         * @return Collection
         */
        public static function getAllJobsCandidates (int $company_id) : Collection
        {
            $jobs = DB::table('candidates as ca')
                ->join('jobs as jo', 'jo.id', '=', 'ca.job_id')
                ->select([
                    'ca.job_id',
                    DB::raw('COUNT(ca.id) as nb_candidates'),
                    'jo.title',
                    'jo.slug'
                ])
                ->where('ca.employer_id', $company_id)
                ->groupBy('ca.job_id')
                ->get();
            
            foreach ($jobs as $job) {
                $job->candidates = DB::table('candidates as ca')
                    ->select([
                        'ca.user_id'
                    ])
                    ->where('ca.job_id', $job->job_id)
                    ->where('ca.employer_id', $company_id)
                    ->get();
                
                self::getCandidatesInfos($job->candidates);
            }
            
            return $jobs;
        }
        
        
        /**
         * @method getSingleJobCandidates
         * Retrieves a single job info + its candidates
         *
         * @param int $companyId
         * @param int $jobId
         *
         * @return false|Model|Builder|object
         */
        public static function getSingleJobCandidates (int $companyId, int $jobId)
        {
            $job = DB::table('candidates as ca')
                ->join('jobs as jo', 'jo.id', '=', 'ca.job_id')
                ->select([
                    'ca.job_id',
                    DB::raw('COUNT(ca.id) as nb_candidates'),
                    'jo.title',
                    'jo.slug'
                ])
                ->where('ca.employer_id', $companyId)
                ->where('ca.job_id', $jobId)
                ->first();
            
            // No job found
            if (is_null($job)) {
                return false;
            }
            
            // Get candidate's ID
            $job->candidates = DB::table('candidates as ca')
                ->select([
                    'ca.user_id'
                ])
                ->where('ca.job_id', $job->job_id)
                ->where('ca.employer_id', $companyId)
                ->get();
            
            self::getCandidatesInfos($job->candidates);
            
            return $job;
        }
        
        /**
         * @method getCandidatesInfos
         * Fetches the information for each candidate
         *
         * @param Collection $candidates
         *
         * @return Collection
         */
        private static function getCandidatesInfos (Collection $candidates) : Collection
        {
            
            foreach ($candidates as $candidate) {
                $freelancerId = DB::table('users as u')
                    ->select('u.freelancer_id')
                    ->where('u.id', '=', $candidate->user_id)
                    ->first()
                    ->freelancer_id;
                
                $candidate->frId = $freelancerId ?? $candidate->user_id;
                
                $candidate->info = DB::table('users as u')
                    ->join('locations as lo', 'lo.id', '=', 'u.location_id')
                    ->join('freelancers as fr', 'fr.user_id', '=', 'u.id')
                    ->join('ratings_freelancers as rafr', 'rafr.freelancer_id', '=', 'fr.id')
                    ->join('skills_freelancers as skfr', 'skfr.id', '=', 'fr.id')
                    ->select([
                        'fr.firstname',
                        'fr.lastname',
                        'fr.verified',
                        'fr.CV_url',
                        'u.dir_url',
                        'u.email',
                        'u.pic_url',
                        'lo.country_name',
                        'lo.country_code',
                        DB::raw('ROUND(SUM(rafr.note)/COUNT(rafr.id)) as rating'),
                        'skfr.skills'
                    ])
                    ->where('fr.id', '=', $candidate->frId)
                    ->first();
                
                // Get skills into an array for output
                $skills = $candidate->info->skills;
                
                if (!is_null($skills)) {
                    $candidate->info->skills = Controller::curateSkills($skills);
                }
            }
            
            return $candidates;
        }
        
        /**
         * @method getAppliedJobs
         * Gets the jobs the freelancer applied for
         *
         * @param int $freelancerId
         *
         * @return Collection
         */
        public static function getAppliedJobs (int $freelancerId) : Collection
        {
            $jobs = DB::table('candidates as ca')
                ->join('jobs as jo', 'jo.id', '=', 'ca.job_id')
                ->join('freelancers as fr', 'fr.user_id', '=', 'ca.user_id')
                ->select([
                    'ca.job_id as id',
                    'jo.slug',
                    'jo.title',
                    'jo.created_at',
                    'fr.user_id as freelancerId'
                ])
                ->where('ca.user_id', '=', $freelancerId)
                ->get();
            
            foreach ($jobs as $job) {
                $job->created_at = Carbon::create($job->created_at)->diffForHumans([
                    'parts' => 2,
                    'join' => ', '
                ]);
            }
            
            return $jobs;
        }
        
        /**
         * @param $bidderId
         *
         * @return Collection
         */
        public static function getActiveBids ($bidderId) : Collection
        {
            return DB::table('bids as bi')
                ->join('tasks as ta', 'ta.id', '=', 'bi.task_id')
                ->select([
                    'bi.id',
                    'bi.task_id',
                    'bi.minimal_rate',
                    'bi.delivery_time',
                    'bi.time_period',
                    'ta.name',
                    'ta.due_date',
                    'ta.slug',
                    'ta.type',
                    'ta.budget_min',
                    'ta.budget_max'
                ])
                ->where('bi.bidder_id', '=', $bidderId)
                ->get();
        }
        
        /**
         * @param bool     $isFreelancer
         * @param int|null $id user freelancer/company id
         *
         * @return RedirectResponse|Collection
         */
        public static function getActiveTasks (bool $isFreelancer, int $id = null)
        {
            if (is_null($id)) {
                return redirect()->route('error-404')->with('message', 'Freelancer/Company ID not set.');
            }
            
            $baseQuery = DB::table('tasks as ta')
                ->select([
                    'ta.id',
                    'ta.name',
                    'ta.slug',
                    'ta.budget_min',
                    'ta.budget_max',
                    'ta.type',
                    'ta.due_date',
                ]);
            
            if ($isFreelancer) {
                $tasks = $baseQuery
                    ->where('ta.freelancer_id', '=', $id)
                    ->get();
                
            }
            else {
                $tasks = $baseQuery
                    ->where('ta.employer_id', '=', $id)
                    ->get();
            }
            
            $tasks = self::getBidsInfo($tasks);
            
            return self::isExpiring($tasks);
        }
        
        /**
         * @param Collection $tasks
         *
         * @return Collection
         */
        private static function getBidsInfo (Collection $tasks) : Collection
        {
            foreach ($tasks as $task) {
                $task->bids = DB::table('bids as bi')
                    ->select([
                        DB::raw('COUNT(bi.id) as amount_bidders'),
                        DB::raw('ROUND(SUM(bi.minimal_rate)/COUNT(bi.id)) as average_bid')
                    ])
                    ->where('bi.task_id', '=', $task->id)
                    ->first();
            }
            
            return $tasks;
        }
        
        /**
         * @param Collection $tasks
         *
         * @return Collection
         */
        private static function isExpiring (Collection $tasks) : Collection
        {
            foreach ($tasks as $task) {
                $dueDate = $task->due_date;
                $timeDiff = Carbon::create($dueDate)->diffForHumans();
                
                // nbDays | weeks/months/years | from | now/ago
                $timeSplit = explode(' ', $timeDiff);
                
                // Expiring === due_date < 1 week
                $task->expiring = ($timeSplit[1] === 'days' && $timeSplit[0] < 7);
                $task->hasExpired = $timeSplit[2] === 'ago';
                
                // Diff for humans
                $task->due_date = $timeDiff;
            }
            
            return $tasks;
        }
    
        /**
         * @method getTaskBidders
         * Retrieves all bidders of a specific task
         *
         * @param int         $taskId
         * @param string|null $sortBy
         *
         * @return Collection
         */
        public static function getTaskBidders (int $taskId, string $sortBy = null) : Collection
        {
            $bidders = DB::table('bids as bi')
                ->join('tasks as ta', 'ta.id', '=', 'bi.task_id')
                ->join('freelancers as fr', 'fr.id', '=', 'bi.bidder_id')
                ->join('users as u', 'u.id', '=', 'fr.user_id')
                ->join('locations as lo', 'lo.id', '=', 'u.location_id')
                ->select([
                    'bi.id',
                    'bi.bidder_id',
                    'bi.time_period',
                    'bi.delivery_time',
                    'bi.minimal_rate',
                    'fr.firstname',
                    'fr.lastname',
                    'fr.verified',
                    'u.email',
                    'u.dir_url',
                    'u.pic_url',
                    'lo.country_code',
                    'lo.country_name',
                    'ta.type',
                    'bi.created_at'
                ])
                ->where('bi.task_id', '=', $taskId)
                ->groupBy('bi.id');
            
            if (!is_null($sortBy)) {
                $bidders = self::sortBidders($bidders, $sortBy);
            }
            
            $bidders = $bidders->get();
            
            return self::getBiddersRatings($bidders);
        }
        
        /**
         * @method getBiddersRatings
         * Sets each bidder's rating
         *
         * @param Collection $bidders
         *
         * @return Collection
         */
        private static function getBiddersRatings (Collection $bidders) : Collection
        {
            foreach ($bidders as $bidder) {
                $bidder->rating = DB::table('ratings_freelancers as rafr')
                    ->select(DB::raw('SUM(rafr.note)/COUNT(rafr.id) as rating'))
                    ->where('rafr.freelancer_id', '=', $bidder->bidder_id)
                    ->first()
                    ->rating;
            }
            
            return $bidders;
        }
        
        /**
         * @sortBidders
         * Sorts the bidders if requested
         *
         * @param Builder $bidders
         * @param string  $sortBy
         *
         * @return Builder
         */
        private static function sortBidders (Builder $bidders, string $sortBy) : Builder
        {
            switch ($sortBy) {
                case 'priceLoHi':
                    $bidders->orderBy('bi.minimal_rate', 'ASC');
                    break;
                case 'priceHiLo':
                    $bidders->orderBy('bi.minimal_rate', 'DESC');
                    break;
                case 'oldest':
                    $bidders->orderBy('bi.created_at', 'ASC');
                    break;
                case 'newest':
                    $bidders->orderBy('bi.created_at', 'DESC');
                    break;
                case 'bidderAZ':
                    $bidders->orderBy('fr.firstname', 'ASC');
                    break;
                case 'bidderZA':
                    $bidders->orderBy('fr.firstname', 'DESC');
                    break;
                case 'reset':
                default:
                    return $bidders;
            }
            
            return $bidders;
        }
    }