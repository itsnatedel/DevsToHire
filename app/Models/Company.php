<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'name',
        'description',
        'verified',
        'pic_url',
    ];

    /**
     * Relation Company -> User
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
