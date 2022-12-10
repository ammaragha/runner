<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Runner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cost_per_hour', 'service_id', 'user_id',"is_active"
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
