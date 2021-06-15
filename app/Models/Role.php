<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    /**
     * Relation Role -> User
     * @return HasMany
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Relation Role -> Freelancer
     * @return HasMany
     */
    public function freelancers() {
        return $this->hasMany(Freelancer::class);
    }

    /**
     * Relation Role -> Company
     * @return HasMany
     */
    public function companies() {
        return $this->hasMany(Company::class);
    }
}
