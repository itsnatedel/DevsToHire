<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Ramsey\Uuid\Uuid;

class Dashboard extends Model
{
    use HasFactory;

    public static function getUserSettings(User $user): User
    {
        //dd($user->role_id);
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
     * @return bool
     */
    public static function checkAndUpdateSettings(array $request, User $user): bool
    {
        $baseUserQuery = DB::table('users as u')
            ->where('u.id', $user->id);

        // Start the update with User's table fields
        $userUpdated = self::updateUsersTableSettings($baseUserQuery, $request, $user);

        if ($userUpdated) {
            if ($user->role_id === 2) {
                $baseFreelancerQuery = DB::table('freelancers as fr')
                    ->where('fr.id', $user->freelancer_id);

                $freelancer = Freelancer::where('id', $user->freelancer_id)->first();

                $freelancerUpdate = self::updateFreelancersTableSettings($baseFreelancerQuery, $request, $freelancer);
            }

            if ($user->role_id === 3) {
                $baseEmployerQuery = DB::table('companies as co')
                    ->where('co.id', $user->company_id);
            }
        }
        // Continue the update with Freelancer's table fields

        // TODO:Case if the user is an employer

        // Upload files
        if (app('request')->file('attachmentUpload')) {
            self::handleFileUpload(app('request'), $user);
        }

        if (app('request')->has('profilePic')) {
            $avatarDir = $_SERVER['DOCUMENT_ROOT'] . '/images/user/' . $user->dir_url . '/avatar/';

            // Clean avatar directory
            $fs = new Filesystem();
            $fs->cleanDirectory($avatarDir);

            $filename = time() . '.' . app('request')->file('profilePic')->extension();

            if (app('request')->file('profilePic')->move(public_path('images/user/' . $user->dir_url . '/avatar'), $filename)) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['pic_url' => $filename]);
            }
        }

        return true;
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
    private static function updateUsersTableSettings($baseQuery, array $request, User $user): bool
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
            && $request['newPassword'] === $request['newPasswordConf']) {
            $baseQuery->update(['password' => $request['newPassword']]);
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
    private static function updateFreelancersTableSettings($baseQuery, array $request, Freelancer $freelancer): bool
    {
        // No need to check if those fields exists, already checked in updateUsersTableSettings method.
        if (!is_null($request['firstname'])
            && !is_null($request['lastname'])) {
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

        if(!is_null($request['skills'])) {
            DB::table('skills_freelancers')
                ->updateOrInsert(
                    ['freelancer_id' => $freelancer->id],
                    ['skills' => json_encode([$request['skills']])]
                );
        }

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
    private static function handleFileUpload(Request $request, User $user): bool
    {
        $filesDirPath = $_SERVER['DOCUMENT_ROOT'] . '/images/user/' . $user->dir_url . '/files/';

        if (!is_dir($filesDirPath)) {
            if (!mkdir($filesDirPath, 0755)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $filesDirPath));
            }
        }
        $filename = Uuid::uuid4() . '.' . $request->file('attachmentUpload')->extension();

        $request->file('attachmentUpload')->move(public_path('images/user/' . $user->dir_url . '/files'), $filename);

        if ($user->role_id === 2) {
            DB::table('freelancers')
                ->where('id', $user->freelancer_id)
                ->update(['CV_url' => $filename]);
        }

        return true;
    }
}
