<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStock extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tracking_stocks';
}
