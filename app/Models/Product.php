<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];


    //--- Relationships ---//
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     // Define the one-to-many relationship with HirePurchase
     public function agreements()
     {
         return $this->hasMany(Agreement::class);
     }
     

    //ACCESSORS
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    // MUTATORS
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
