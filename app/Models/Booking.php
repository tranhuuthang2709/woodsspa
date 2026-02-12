<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'number_of_people',
        'booking_date',
        'booking_time',
        'note',
        'status',
    ];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
