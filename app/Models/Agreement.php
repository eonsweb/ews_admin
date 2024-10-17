<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    //inverse relationship (Many-to-One) with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //one-to-many relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // inverse relationship (Many-to-One) with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
