<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'created_at',
        'modified_at',
        'title',
        'salary_low',
        'salary_high',
        'type',
        'description',
    ];

    /**
     * Relation Job -> Company
     * @return BelongsTo
     */
    public function company() {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation Job -> Category
     * @return BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
