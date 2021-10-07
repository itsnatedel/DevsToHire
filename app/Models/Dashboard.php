<?php
    
    namespace App\Models;
    
    use App\Http\Requests\StoreJobRequest;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Filesystem\Filesystem;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
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
                        $resizedImage = Image::make(app('request')->file('profilePic'))->resize(42,42);
                        
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
                } else {
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
    }