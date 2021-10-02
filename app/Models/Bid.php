<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';
    protected $fillable = [
        'minimal_rate',
        'delivery_time',
        'time_period',
    ];

    public $timestamps = true;

    /**
     * Relation Bid -> Task
     * @return BelongsTo
     */
    public function tasks(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Relation Bid -> Freelancer
     * @return BelongsTo
     */
    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(Freelancer::class);
    }
}