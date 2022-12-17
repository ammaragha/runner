<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description', 'voice', 'date', 'time', 'urgent', 'complex',
        'care_for', 'response', 'status', "properties",
        'deal', 'end_time', 'end_date',
        'user_id', 'runner_id', 'address_id', "service_id"
    ];

    protected $casts = [
        // "date" => 'date:Y-m-d',
        // "time" => 'date:H:i',
        "properties" => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function runner()
    {
        return $this->belongsTo(User::class, 'runner_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
