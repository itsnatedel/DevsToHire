<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Freelancer extends Model
{
    use HasFactory;

    protected $table = 'freelancers';
    protected $fillable = [
        'description',
        'pic_url',
        'hourly_rate',
        'CV_url'
    ];

    /**
     * Relation Freelancer -> Bid
     * @return HasMany
     */
    public function bids() {
        return $this->hasMany(Bid::class);
    }

    /**
     * Relation Freelancer -> User
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
