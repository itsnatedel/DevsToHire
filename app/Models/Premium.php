<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    protected $table = 'premium';
    protected $fillable = [
        'plan',
        'description',
        'monthly_price',
        'yearly_price',
        'listing',
        'visibility_days',
        'highlighted',
    ];

    public $timestamps = false;
}
