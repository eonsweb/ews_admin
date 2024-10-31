<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at'  => 'datetime'
    ];

    public function agreement()
    {
        return $this->hasMany(Agreement::class);
    }
}
