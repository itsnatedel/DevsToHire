<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'account-type' => ['required'],
            'password' => ['required_with:password_confirmation', 'string', Password::min(8)->letters()->mixedCase()->numbers()],
            'country' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        $data = $this->setRoleId($data);
        $data = $this->setLocationId($data);

        return User::create([
            'firstname'     => $data['firstname'],
            'lastname'      => $data['lastname'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'role_id'       => $data['account-type'],
            'location_id'   => $data['country'],
            'created_at'    => Carbon::now(),
        ]);
    }

    protected function setRoleId(array $data): array
    {
        $data['account-type'] = $data['account-type'] === 'freelancer'
            ? 2
            : 3;

        return $data;
    }

    protected function setLocationId(array $data): array
    {
        $data['country'] = DB::table('locations')
            ->select('id')
            ->where('country_code', '=', $data['country'])
            ->first()
            ->id;

        return $data;
    }
}
