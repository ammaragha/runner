<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'city',
        'state',
        'lat',
        'long',
        'street',
        'suite',
        'zip',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
