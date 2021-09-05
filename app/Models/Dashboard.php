<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    public static function getUserSettings(User $user)
    {
        //dd($user->role_id);

        $user->stats = $user->role_id === 2
            ? Freelancer::where('user_id', $user->id)->first()
            : Company::where('user_id', $user->id)->first();
        $free = Freelancer::where('user_id', $user->id)->first();
    }
}
