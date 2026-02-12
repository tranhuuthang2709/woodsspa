<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'service_option_id',
        'person_name',
        'note',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function serviceOption()
{
    return $this->belongsTo(ServiceOption::class);
}   
 public function translations()
{
    return $this->belongsTo(ServiceOption::class);
}
}
