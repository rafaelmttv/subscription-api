<?php

namespace App\Models;

use App\Enums\PlanStatus;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'monthly_price',
        'order_limit',
        'status',
    ];

    protected $casts = [
        'status' => PlanStatus::class,
    ];
}
